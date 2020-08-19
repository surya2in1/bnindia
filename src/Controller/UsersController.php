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


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
   
   /**
    * Function login for members
    */
    public function login()
    {
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
             // debug($user);
            if ($user) {
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
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
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
                                    ->select(['id','group_number']);
                            },      
                         ],
        ])->toArray();
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

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
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
        return $this->redirect($this->Auth->logout());
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
                
                $msg= 'Hello '.$email.'<br/> Please click link below to reset your password<br/><br/><a href="http://localhost/bnindia/resetpassword/'.$mytocken.'">Reset Password</a>';
                
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
        // echo $name.'<pre>';print_r($post);
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
             $output = $this->Users->GetData();
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
            $MembersGroupsTable = TableRegistry::get('MembersGroups');
            $member_groups = $MembersGroupsTable->find('all')->where(['user_id'=>$id])->toArray();
            if(!empty($member_groups)){
                foreach ($member_groups as $key => $value) { 
                    $selected_member_groups[$key] = $value->group_id; 
                }
            }
            // echo '<pre>';print_r($selected_member_groups);exit;
        }else{
            $user = $this->Users->newEmptyEntity();
        }
        $this->set('selected_member_groups',$selected_member_groups);
        // get groups
        $GroupsTable = TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'group_number'
                                    ])->where(['status'=>1])->toArray();;
        if ($this->request->is(['patch', 'post', 'put'])) {

            $post = $this->request->getData();
            // echo $id.'<pre>';print_r($post);exit;

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
            //create random password
            $post['password'] = $this->Common->randomPassword();

            //find member role id
            $RolesTable = TableRegistry::get('Roles');
            $role = $RolesTable->find('all')->where(['name'=>'member'])->first();
            $post['role_id'] = $role->id;

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
                    $usertable = TableRegistry::get("Users");
                    $query = $usertable->query();
                    $result = $query->update()
                            ->set($updateuser)
                            ->where(['id' => $result->id])
                            ->execute();
                }

                //Add member groups
                if(isset($post['group_ids']) && !empty($post['group_ids'])){
                    //delete existing data
                    $this->MembersGroups->deleteAll(['user_id' => $result->id]);
                    foreach ($post['group_ids'] as  $group_id) {
                        $group_record['user_id'] = $result->id;
                        $group_record['group_id'] = $group_id;
                        $group_records[] = $group_record;
                    }
                    $MembersGroups = $this->MembersGroups->newEntities($group_records);
                    $this->MembersGroups->saveMany($MembersGroups);
                }   
                if($id<1){
                    // send password to user
                    $msg ="Hello ".$post['first_name'].'\r\n';
                    $msg .="Welcome to Bnindia application, your newly genereted password is below,".'\r\n';
                    $msg .= "Password: ". $post['password'].'\r\n';
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
        $this->set(compact('user'));
        $this->set('groups',$groups);
     }

}
