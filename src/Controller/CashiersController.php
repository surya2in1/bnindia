<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\Mailer\Transport;
use Cake\Core\Configure;
/**
 * Cashiers Controller
 *
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CashiersController extends AppController
{
     public function initialize(): void
    {
        parent::initialize(); 
        $this->loadComponent('Common');
        $this->loadModel('Users');
    }

    /**
     * Add or edit branch head details
     * */
    function cashierform($id=null){
         $this->viewBuilder()->setLayout('admin');
       
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }

        if($id>0){
            $user = $this->Users->get($id, [
                'contain' => [],
            ]); 
        }else{
            $user = $this->Users->newEmptyEntity();
        } 
        $this->set(compact('user'));
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
            $role = $RolesTable->find('all')->where(['name'=>Configure::read('ROLE_USER')])->first();
            $post['role_id'] = $role->id;
            $post['created_by'] = $this->Auth->user('id');
            // echo '<pre>';print_r($post);exit;
            $user = $this->Users->patchEntity($user, $post);

            if ($result = $this->Users->save($user)) {  
                $profile_picture = $profile_picture_data;
                if($profile_picture_data && $profile_picture_data->getClientFilename()){
                   $updateuser['profile_picture'] = $this->Common->userDocUpload('profile_picture', $profile_picture_data,WWW_ROOT.'img'.DS."user_imgs",$result->id,'users'); 
                }
                          
                //upload documnts\
                if($address_proof && $address_proof->getClientFilename()){
                    $updateuser['address_proof'] = $this->Common->userDocUpload('address_proof',$address_proof,'', $result->id,'users');
                }

                if($photo_proof &&  $photo_proof->getClientFilename()){
                    $updateuser['photo_proof'] = $this->Common->userDocUpload('photo_proof',$photo_proof,'', $result->id,'users');
                }
                if($other_document &&  $other_document->getClientFilename()){
                    $updateuser['other_document'] = $this->Common->userDocUpload('other_document',$other_document,'', $result->id,'users');
                } 
                //update user docs
                if(isset($updateuser)){ 
                    $usertable = TableRegistry::get("Users");
                    $query = $usertable->query();
                    $query->update()
                            ->set($updateuser)
                            ->where(['id' => $result->id])
                            ->execute();
                }   

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
        
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('admin');    
        if ($this->request->is('post')) {
             $output = $this->Users->GetRoleWiseData($this->Auth->user('id'),Configure::read('ROLE_USER')); 
             echo json_encode($output);exit;
        }
    }

    /**
     * View method
     *
     * @param string|null $id Agent id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');    
        $user = $this->Users->get($id, [
            'contain' => [],
            'conditions'=>['status'=>1]
        ]);

        $this->set(compact('user'));
    }
  
}
