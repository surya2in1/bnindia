<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Http\Cookie\cookie;
use Cake\I18n\Time;
use Cake\Http\Cookie\CookieCollection;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Mailer\TransportFactory;
use Cake\Mailer\Transport;
use Cake\Log\Log;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
   function superadminlogin($id){ 
    $superadmin_id = $this->Auth->user('id'); 
    $this->setLoginUser($id,1,$superadmin_id);
   }

public function setLoginUser($id,$login_by_superadmin,$superadmin_id)
{
    $this->Auth->logout();
   //Set login as new user
    $user = $this->Users->get($id, [
                'contain' => [
                                 'Roles' => function ($q) {
                                    return $q
                                        ->select(['id','name'])
                                        ->contain(['RolePermissions' => function ($q) {
                                                return $q
                                                    ->select(['RolePermissions.role_id','Modules.name','Permissions.permission'])
                                                    ->contain(['Modules','Permissions']);
                                            },  
                                        ]);
                                },      
                             ],
            ])->toArray(); 
    $user['login_by_superadmin'] =$login_by_superadmin;
    $user['superadmin_id']=$superadmin_id;
    $this->Auth->setUser($user);
    // echo '<pre>';print_r( $this->Auth->user());exit;
    if($login_by_superadmin ==1){
        return $this->redirect('/');
    }else{

        return $this->redirect('/AllUsers');
    }
}


   /**
    * Function login for members
    */
    public function login()
    {
        \Cake\Cache\Cache::clear();
        if ($this->Auth->user()) {
            return $this->redirect('/dashboard');
        }
        $this->viewBuilder()->setLayout('login');
        // $this->response = $this->response->withCookie(
        //                     (new Cookie('remember_me'))
        //                         ->withValue('fdfg')
        //                         ->withExpiry(new Time('+1 month'))
        //                         ->withHttpOnly(true)
        //                 );
         
        // Cookie::read();
//                             echo "ss <pre>";print_r($_COOKIE);
// exit();
        if ($this->request->is('post')) {
            $post = $this->request->getData(); 
            $user = $this->Auth->identify();
            
             // debug($user);exit;
            if ($user) {
                $user = $this->Users->get($user['id'], [
                    'contain' => [
                                     'Roles' => function ($q) {
                                        return $q
                                            ->select(['id','name'])
                                            ->contain(['RolePermissions' => function ($q) {
                                                    return $q
                                                        ->select(['RolePermissions.role_id','Modules.name','Permissions.permission'])
                                                        ->contain(['Modules','Permissions']);
                                                },  
                                            ]);
                                    },      
                                 ],
                ])->toArray(); 

                $user['login_by_superadmin'] =0;
                $user['superadmin_id']=0;
                // echo "user <pre>";print_r($user);exit;
                $this->Auth->setUser($user);
                //Check remeber me 
                if (isset($post['remember_me']) && $post['remember_me'] == 'on') {     
                    $cookie = Cookie::create(
                                    'remember_me',
                                    'setdata',
                                    [
                                        'expires' => new time('+1 year'),
                                        'path' => '/login',
                                        'secure' => false,
                                        'httponly' => false,
                                    ]
                                );
       
                    // $cookie = new Cookie(
                    //                         'remember_me', // name
                    //                         serialize($post), // value
                    //                         new time('+1 year'), // expiration time, if applicable
                    //                         '/', // path, if applicable
                    //                         'http://localhost/bnindia/', // domain, if applicable
                    //                         false, // secure only?
                    //                         false // http only ? );
                    // );

                    $cookies = new CookieCollection([$cookie]);//To create new collection
                    $cookies = $cookies->add($cookie);//to add in existing collection
                       $cookie = $cookies->get('remember_me');
                    //  echo "ss <pre>";print_r($cookie);
                   //  echo "ss <pre>";print_r($_COOKIE);
                   // exit;

                }else{
                   // setcookie ("remember_me_cookie",''); 
                }
                echo 1;exit;
            } else {
                echo 0;exit;
            }
        } 
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $membergroups= TableRegistry::get('MembersGroups');
        $membergroup = $membergroups->find('all', [
            'contain' => [
                             'Groups' => function ($q) {
                                return $q
                                    ->select(['id','group_code']);
                            },      
                         ],
        ])->where(['MembersGroups.user_id' => $id])->toArray();
        // echo '<pre>';print_r($membergroup);exit;
        $this->set(compact('user'));
        $this->set('membergroups',$membergroup);
    }

    /**
     * signup method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful signup, renders view otherwise.
     */
    public function signup()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            unset($postData['agree']);
            unset($postData['rpassword']);
             $user = $this->Users->patchEntity($user, $postData);
            if ($this->Users->save($user)) {
                echo 1;
            }else{
                $validationErrors = $user->getErrors();
                // echo '<pre>';print_r($user->getErrors());
                if(isset($validationErrors['email']['_isUnique']) && !empty($validationErrors['email']['_isUnique'])){
                    echo 'email_unique';
                }else{
                    echo 0;
                }
            }
            exit;
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $MembersGroupsTable = TableRegistry::get('MembersGroups');
        $membergroup = $MembersGroupsTable->find('all')->where(['user_id'=>$id])->first();
        if($membergroup){
            echo 'group_associated_with_members';
        }else{
            $user = $this->Users->get($id);
            if ($this->Users->delete($user)) {
                echo 1;
            } else {
                echo 0;
            }
        }
        exit;
    }

    /**
    * Function logout for members
    */
    public function logout()
    {
        //check if login by superadmin
        $login_by_superadmin = $this->Auth->user('login_by_superadmin');
        $superadmin_id = $this->Auth->user('superadmin_id');
        if($login_by_superadmin == 1){
            $this->setLoginUser($superadmin_id,0,0);
        }else{
            return $this->redirect($this->Auth->logout());

        }
    }

    /**
    * Function forgot password
    */
    public function forgotPassword()
    {
        // Please specify your Mail Server - Example: mail.example.com.
        ini_set("SMTP","riyajaya692@gmail.com");

        // Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
        ini_set("smtp_port","25");

        // Please specify the return address to use
        ini_set('sendmail_from', 'riyajaya692@gmail.com');

        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $mytocken = Security::hash(Security::randomBytes(25));

            $UsersTable = TableRegistry::get('Users');
            $user = $UsersTable->find('all')->where(['email'=>$email])->first();
            $user->token = $mytocken;
            if($UsersTable->save($user)){
                //send email 
                TransportFactory::setConfig('gmail', [
                  'host' => 'ssl://smtp.gmail.com',
                  'port' => 25,
                  'username' => 'riyajaya692@gmail.com',
                  'password' => 'etgtxblbsftaupzd',
                  'className' => 'Smtp'
                ]);
                
                $msg= 'Hello '.$email."\r\n".' Please click link below to reset your password<br/>'."\r\n".'<a href="http://localhost/bnindia/resetpassword/'.$mytocken.'">Reset Password</a>'."\r\n"."\r\n".'Thank you,'."\r\n".'Bnindia team';
                
                try {
                    Email::deliver($email, 'Please confirm your reset password', $msg, ['from' => 'votreidentifiant@gmail.com']);
                    $response = 1;
                } catch (Exception $e) {
                    $response = 0;
                }
            } 
        }
        echo $response;exit;
    }

    /**
    * Function reset password
    */
    public function resetPassword($token)
    {
        if ($this->Auth->user()) {
            return $this->redirect('/dashboard');
        }
        $this->set('token',$token);
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $password = $this->request->getData('password');
            $UsersTable = TableRegistry::get('Users');
            $user = $UsersTable->find('all')->where(['token'=>$token])->first();
            $user->password = $password;
            if($UsersTable->save($user)){
                echo 1;
            }else{
                echo 0;
            }
            exit;
        }
    }

    /**
    * Function personal info
    */
    public function personalinfo(){
        $this->viewBuilder()->setLayout('admin');
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        // echo '<pre>';print_r($user);exit();
        $this->set('user',$user);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // echo '<pre>';print_r($this->request->getData());

            $post = $this->request->getData();

            //convert dates to db field format
            if(strtotime($post['date_of_birth']) > 0){
                $post['date_of_birth'] = date('Y-m-d',strtotime($post['date_of_birth']));
            }
            if(strtotime($post['nominee_dob']) > 0){
                $post['nominee_dob'] = date('Y-m-d',strtotime($post['nominee_dob']));
            }
            //upload docs
            $profile_picture_data = $post['profile_picture'];
            $address_proof = $post['address_proof'];
            $photo_proof = $post['photo_proof'];
            $other_document = $post['other_document'];

            //remove unnecessary data for db validation
            unset($post['profile_picture']);
            unset($post['address_proof']);
            unset($post['photo_proof']);
            unset($post['other_document']);

            $user = $this->Users->patchEntity($user, $post);
            $validationErrors = $user->getErrors();
            // echo 'validationErrors <pre>';print_r($validationErrors);exit;
            if(empty($validationErrors)){
                $profile_picture = $profile_picture_data;
                if($profile_picture_data && $profile_picture_data->getClientFilename()){
                   $user->profile_picture = $this->userDocUpload('profile_picture', $profile_picture_data,WWW_ROOT.'img'.DS."user_imgs"); 
                }
                          
                //upload documnts\
                if($address_proof && $address_proof->getClientFilename()){
                    $user->address_proof = $this->userDocUpload('address_proof',$address_proof);
                }

                if($photo_proof && $photo_proof->getClientFilename()){
                    $user->photo_proof = $this->userDocUpload('photo_proof',$photo_proof);
                }
                if($other_document && $other_document->getClientFilename()){
                    $user->other_document = $this->userDocUpload('other_document',$other_document);
                }
            }


           // echo 'user <pre>';print_r($user);exit;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved successfully.'));

                return $this->redirect(['action' => 'personalinfo']);
            }

            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }

    /**
    * this function ussed for image and user documents upload
    * fun used for profile inf and member add edit
    */
    public function userDocUpload($db_upload_field, $post, $path = '', $id=0){
        $name = $post->getClientFilename();
        $filename = '';
        if($name){
            $name = preg_replace('/[(){}]/', '', $name);
            $name = str_replace(' ', '', $name);

            $sffledStr= str_shuffle('encrypt');
            $uniqueString = md5(time().$sffledStr);
            if ($id < 1) {
                $id = $this->Auth->user('id');
            }
            $user = $this->Users->get($id);

            //create path
            if(empty($path)){
                $path = WWW_ROOT.DS.'users_docs'.DS.$db_upload_field;
            }
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            //get exsiting doc from db 
            $existing_doc = $user->$db_upload_field;
            if (($existing_doc) && file_exists($path.DS.$existing_doc)){
                unlink( $path.DS.$existing_doc);
            }
            
            $filename = $id.'_'.$uniqueString.'_'.$name;
            $targetPath = $path.DS.$filename;
            $post->moveTo($targetPath);
        }
        return $filename;
    }

    /**
    * Function change password
    */
    public function changePassword()
    {
        $this->viewBuilder()->setLayout('admin');
        $id = $this->Auth->user('id');
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        // debug($this->Auth->user());
        $this->set('user',$user);
        if ($this->request->is('post')) {
            // echo '<pre>';print_r($this->request->getData());
            $db_password = $user->password;
            $current_password = $this->request->getData('current_password');
            $password = $this->request->getData('password');
            
            //Check old password is correct or not            
            $check_password = (new DefaultPasswordHasher)->check($current_password,$db_password);
            if($check_password == false){
                $this->Flash->error(__('Current password not matchced. Please, try again.'));
            }elseif((new DefaultPasswordHasher)->check($password,$db_password)){
                $this->Flash->error(__('New password is same as old. Please change new password.'));
            }else{
                $UsersTable = TableRegistry::get('Users');
                $user = $UsersTable->find('all')->where(['id'=>$id])->first();
                $user->password = $password;
                if($UsersTable->save($user)){
                    $this->Flash->success(__('Password changed successfully.'));
                    return $this->redirect(['action' => 'changePassword']);
                }
                $this->Flash->error(__('The password could not be changed. Please, try again.'));
            }
            
        }
    }

    /**
    * Members list
    */
    public function members()
    {
        $this->viewBuilder()->setLayout('admin');    
        if ($this->request->is('post')) {
             $output = $this->Users->GetData($this->Auth->user('id'));
             // debug($output);exit;
             echo json_encode($output);exit;
        }
        
    }
    
    /*
    ** add edit member
    */
     function memberform($id=null){
        $this->viewBuilder()->setLayout('admin');
       
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }

        $this->loadModel('MembersGroups');
        $selected_member_groups = []; 
        if($id>0){
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
            // $MembersGroupsTable = TableRegistry::get('MembersGroups');
            // $member_groups = $MembersGroupsTable->find('all')->where(['user_id'=>$id])->toArray();
            // if(!empty($member_groups)){
            //     foreach ($member_groups as $key => $value) { 
            //         $selected_member_groups[$key] = $value->group_id; 
            //     }
            // }
        }else{
            $user = $this->Users->newEmptyEntity();
        }
        // $this->set('selected_member_groups',$selected_member_groups);
        //Get available groups
        // $GroupsTable = TableRegistry::get('Groups');
        // $groups = $GroupsTable->find('list', [
        //                                 'keyField' => 'id',
        //                                 'valueField' => 'group_number'
        //                             ])->where(['status'=>1])->toArray();
        // // echo '<pre>';print_r($selected_member_groups);
        // // echo '<pre>';print_r($groups);exit;
        // $full_groups= [];
        // if(!empty($groups)){
        //     foreach ($groups as $key=> $value) {
        //           $grouplist[] = $key; 
        //     }
        //      if(!empty($selected_member_groups)){
        //         $remaning_full_groups = array_diff($selected_member_groups, $grouplist);
        //          if($remaning_full_groups){
        //             foreach ($remaning_full_groups as  $value) {
        //                 $result = $GroupsTable->find('list', [
        //                                         'keyField' => 'id',
        //                                         'valueField' => 'group_number'
        //                                     ])->where(['id'=>$value])->toArray();
        //                 $full_groups = $full_groups + $result;
        //             }
        //         }
        //     }

        // }
        //  $this->set('full_groups',$full_groups);
        // $this->set('groups',$groups);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $post = $this->request->getData();
            // echo $id.'<pre>';print_r($post);exit;

            //convert dates to db field format
            if(strtotime($post['date_of_birth'])){
                $post['date_of_birth'] = date('Y-m-d',strtotime($post['date_of_birth']));
            }
            if(strtotime($post['nominee_dob'])){
                $post['nominee_dob'] = date('Y-m-d',strtotime($post['nominee_dob']));
            }
            //upload docs
            $profile_picture_data = $post['profile_picture']; 
            $address_proof = $post['address_proof'];
            $photo_proof = $post['photo_proof'];
            $other_document = $post['other_document'];

            //remove unnecessary data for db validation
            unset($post['profile_picture']);
            unset($post['address_proof']);
            unset($post['photo_proof']);
            unset($post['other_document']);
            //create random password
            $post['password'] = $this->Common->randomPassword();

            //find member role id
            $RolesTable = TableRegistry::get('Roles');
            $role = $RolesTable->find('all')->where(['name'=>'member'])->first();
            $post['role_id'] = $role->id;
            $post['created_by'] = $this->Auth->user('id');
            // echo '<pre>';print_r($post);exit;
            $user = $this->Users->patchEntity($user, $post);
            if ($result = $this->Users->save($user)) {  
                $profile_picture = $profile_picture_data;
                if($profile_picture_data && $profile_picture_data->getClientFilename()){
                   $updateuser['profile_picture'] = $this->userDocUpload('profile_picture', $profile_picture_data,WWW_ROOT.'img'.DS."user_imgs",$result->id); 
                }
                          
                //upload documnts\
                if($address_proof && $address_proof->getClientFilename()){
                    $updateuser['address_proof'] = $this->userDocUpload('address_proof',$address_proof,'', $result->id);
                }

                if($photo_proof &&  $photo_proof->getClientFilename()){
                    $updateuser['photo_proof'] = $this->userDocUpload('photo_proof',$photo_proof,'', $result->id);
                }
                if($other_document &&  $other_document->getClientFilename()){
                    $updateuser['other_document'] = $this->userDocUpload('other_document',$other_document,'', $result->id);
                } 
                //update user docs
                if(isset($updateuser)){
                    //update/add customer id
                    // $updateuser['customer_id'] = '00'.$result->id;
                    $usertable = TableRegistry::get("Users");
                    $query = $usertable->query();
                    $query->update()
                            ->set($updateuser)
                            ->where(['id' => $result->id])
                            ->execute();
                }

                // $MembersGroupsTable = TableRegistry::get('MembersGroups');
                // //Add member groups
                // if(isset($post['group_ids'][0]) && !empty($post['group_ids'][0])){
                //     //delete existing data
                //     $this->MembersGroups->deleteAll(['user_id' => $result->id]);
                //     foreach ($post['group_ids'] as  $group_id) {
                //         $group_record['user_id'] = $result->id;
                //         $group_record['group_id'] = $group_id;
                //         $group_records[] = $group_record;
                //     }

                //     $MembersGroups = $this->MembersGroups->newEntities($group_records);
                //     $this->MembersGroups->saveMany($MembersGroups);
                    
                //     //Check group is full and change the group status
                //     //Get the member groups count
                //     foreach ($post['group_ids'] as $group_id) {
                //         $GroupsTable = TableRegistry::get('Groups');
                //         $query = $MembersGroupsTable->find()->where(['group_id'=>$group_id]);
                //         $member_group_count = $query->count();
                //         $group_total_no = $GroupsTable->find('all')->where(['id'=>$group_id])->first()->toArray();

                //         if($group_total_no['total_number'] == $member_group_count){
                //             //update group status as full i.e 0
                //             $query = $GroupsTable->query();
                //             $query->update()
                //                 ->set(['status' => 0])
                //                 ->where(['id' => $group_id])
                //                 ->execute();

                //         }
                //     }
                // }   

                if($id<1){
                    // send password to user
                    $msg ="Hello ".$post['first_name']."\r\n";
                    $msg .="Welcome to Bnindia application, your newly genereted password is below,"."\r\n";
                    $msg .= "Password: ". $post['password']."\r\n";
                    $msg .= 'Thank you,'."\r\n".'Bnindia team';
                    //temparary comment send mail
                    $send = $this->Common->sendmail($post['email'],'Bnindia application password',$msg);
                    if($send){
                        echo 1;
                    }else{
                        echo 2;
                    }
                }else{
                    echo 1;
                }
            }else{
                 $validationErrors = $user->getErrors();
                //echo '<pre>';print_r($user->getErrors());
                if(isset($validationErrors['email']['_isUnique']) && !empty($validationErrors['email']['_isUnique'])){
                    echo 'email_unique';
                }else{
                    echo 0;
                } 
            }
            exit;
        }
        //echo '<pre>';print_r($user);exit();

        //get agents list 
        $this->loadModel('Agents');


        // $GroupsTable = TableRegistry::get('Groups');
        $agent_list = $this->Agents->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'agent_code' 
                                    ])
                    ->where(['status '=>0,'created_by'=>$this->Auth->user('id')])->toArray();

        $this->set(compact('user','agent_list'));
     }

     function getMembers($query_string,$group_id=0,$selected_member_ids=0){
        $members = [];
        if (!empty($query_string) and $group_id>0) {
             $query = $this->Users->find();
             $config_member_role=Configure::read('ROLE_MEMBER');
             //Excapt admin search all member
             $where_Conditions['r.name']  = $config_member_role; 
             $where_Conditions['Users.created_by']  = $this->Auth->user('id'); 
             if($query_string > 0){
                $where_Conditions['Users.customer_id'] = $query_string;
             }else{
                 $where_Conditions['CONCAT(first_name," ",middle_name," ",last_name) LIKE '] = '%'.$query_string.'%';
             }

             if($selected_member_ids > 0){
                $where_Conditions['Users.id NOT IN'] = explode(',', $selected_member_ids);
             }

             if($group_id > 0){ 
                $where_Conditions['OR'] = [
                                        'mg.group_id !=' => $group_id,
                                        'group_id is ' => null
                                    ];

                //if same member assign for 2 different group then that member must not be display because that member already assign to this group
                $where_Conditions['AND'] = [1 =>$query->newExpr("NOT EXISTS (SELECT 1 FROM members_groups mg2 WHERE mg2.user_id = Users.id and mg2.group_id = ".$group_id.")")
                                    ];       
             }
             $members = $query->select(['name' => $query->func()->concat(['first_name' => 'identifier', ' ','middle_name' => 'identifier', ' ', 'last_name' => 'identifier'])])
             ->select(['Users.customer_id','Users.id','Users.address'])
             ->join([
                'table' => 'members_groups',
                'alias' => 'mg',
                'type' => 'LEFT',
                'conditions' => 'mg.user_id = Users.id',
            ])
             ->join([
                'table' => 'roles',
                'alias' => 'r',
                'type' => 'LEFT',
                'conditions' => 'r.id = Users.role_id',
            ])
            ->where($where_Conditions)
            ->group('Users.id')
            ->toArray(); 
            //   echo '<pre>';print_r($members);exit();
        }

        echo json_encode($members);exit;
        
     }

     /**
     *  Ass member user
     */
     function addMemberUser(){
        $post = $this->request->getData();
        $result = '';
        if(isset($post['group_id']) && isset($post['user_id'])){
            $this->loadModel('MembersGroups');
            $MembersGroupsTable = TableRegistry::get('MembersGroups');
            $isExistMemberGroup = $MembersGroupsTable->find('all')->where(['user_id'=>$post['user_id'],'group_id' => $post['group_id']])->first();

            if($isExistMemberGroup){
                echo 'exist_member_group'; exit();
            } 

            $group_record['user_id'] = $post['user_id'];
            $group_record['group_id'] = $post['group_id'];
            $group_record['created_by'] =$this->Auth->user('id');
            $group_records[] = $group_record;
            $MembersGroups = $this->MembersGroups->newEntities($group_records);
            $result = $this->MembersGroups->saveMany($MembersGroups);
            // echo 'result <pre>';print_r($result);
            if(isset($result[0]->id)){
                //Check group is full and change the group status
                //Get the member groups count
                $group_id = $post['group_id']; 
                $GroupsTable = TableRegistry::get('Groups');
                $query = $MembersGroupsTable->find()->where(['group_id'=>$group_id]);
                $member_group_count = $query->count();
                $group_total_no = $GroupsTable->find('all')->where(['id'=>$group_id])->first()->toArray();

                if($group_total_no['total_number'] == $member_group_count){
                    //update group status as full i.e 0
                    $query = $GroupsTable->query();
                    $query->update()
                        ->set(['status' => 0])
                        ->where(['id' => $group_id])
                        ->execute();
                    echo 'full_group';    
                }else{
                    echo true;exit();
                } 
            }else{ 
                echo false;exit();
            }
        }

        echo false;exit;            
     }
    
     function transferMembers(){
        $this->viewBuilder()->setLayout('admin');    
        if ($this->request->is('post')) {
             $output = $this->Users->getVaccantUsers($this->Auth->user('id'));
             // debug($output);exit;
             echo json_encode($output);exit;
        }
     }

     function transferGroupUser(){
        if ($this->request->is('post')) { 
            $post = $this->request->getData();
            // echo '$post<pre>';print_r($post);//exit;
            if($post['group_id'] and $post['user_id'] and $post['new_group_users_list']){
                $this->loadModel('MembersGroups');
                $query = $this->MembersGroups->find()->where(['group_id' => $post['group_id'],'user_id'=>$post['new_group_users_list']]);
                $member_group_count = $query->count();

                //If group not assigned to new member then insert in members_groups
                if($member_group_count < 1){
                    $group_record['user_id'] = $post['new_group_users_list'];
                    $group_record['group_id'] = $post['group_id'];
                    $group_record['new_user_id'] = $post['new_group_users_list'];
                    $group_record['old_user_id'] = $post['user_id'];
                    $group_record['removal_resaon'] = $post['removal_resaon'];
                    $group_record['remark'] = $post['remark'];
                    $group_record['created_by'] =$this->Auth->user('id');
                    $group_record['date_of_removal'] =date('Y-m-d',strtotime($post['date_of_removal']));
                    $group_records[] = $group_record;
                    $MembersGroups = $this->MembersGroups->newEntities($group_records);
                    $result = $this->MembersGroups->saveMany($MembersGroups);
                }else{
                    //update as new member
                    $query = $this->MembersGroups->query();
                    $result = $query->update()
                        ->set(['new_user_id'=> $post['new_group_users_list'],'old_user_id' => $post['user_id'],
                             'removal_resaon' => $post['removal_resaon'],
                            'remark' => $post['remark'],
                            'date_of_removal'=>date('Y-m-d',strtotime($post['date_of_removal']))
                        ])
                        ->where(['group_id' => $post['group_id'],'user_id'=>$post['user_id']])
                        ->execute();
                }
                //update as old member
                $query = $this->MembersGroups->query();
                $update = $query->update()
                    ->set(['is_transfer_user' => 1,'new_user_id'=> $post['new_group_users_list'],'old_user_id' => $post['user_id'],
                        'removal_resaon' => $post['removal_resaon'],
                        'remark' => $post['remark'],
                        'date_of_removal'=>date('Y-m-d',strtotime($post['date_of_removal']))
                        ])
                    ->where(['group_id' => $post['group_id'],'user_id'=>$post['user_id']])
                    ->execute();
                echo 1;exit;
            }else{
                echo 0;exit;
            }
        }
     }

     function getTransferGroupUser($user_id,$group_id){
        $user = $this->Auth->user();
        $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
        //Get vaccant group users
        $vaccant_members = $this->Common->getVacantMemberDetails($this->Auth->user('id'),0,$user_role, $this->Auth->user('created_by'));   
        $user_ids=[];
        if(!empty($vaccant_members)){
            foreach ($vaccant_members as $key => $value){
                $user_ids[] = $value->user_id;
            }
        }
        $unique_user_ids = array_unique($user_ids);
        //echo '$unique_user_ids<pre>';print_r($unique_user_ids);
        $output = $this->Common->getTransferGroupUser($unique_user_ids,$group_id);

        echo json_encode($output);exit;
     }
}

