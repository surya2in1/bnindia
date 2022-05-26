<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\Mailer\Transport;
/**
 * AllUsersController Controller
 *
 */
class AllUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
       $this->viewBuilder()->setLayout('admin');
        if ($this->request->is('post')) { 
            $this->loadModel('Users');
            $output = $this->Users->GetSuperAdminData($this->Auth->user('id')); 
             echo json_encode($output);exit;
        }
    }
    
    function createadminform($id=null){
        $this->viewBuilder()->setLayout('admin');
         $this->loadModel('Users');
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
            
            //Check is branch duplicate
            $isBranchDuplicate = $this->Users->find('all')->where(['branch_name'=>trim($post['branch_name'])])->first();
            if(!empty($isBranchDuplicate)){
                echo 'duplicate_branch';exit;
            }

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
            $role = $RolesTable->find('all')->where(['name'=>'admin'])->first();
            $post['role_id'] = $role->id;
            $post['status'] = 0;
            $post['created_by'] = $this->Auth->user('id');
            // echo '<pre>';print_r($post);exit;
            $user = $this->Users->patchEntity($user, $post);
            if ($result = $this->Users->save($user)) {  
                $profile_picture = $profile_picture_data;
                if($profile_picture_data && $profile_picture_data->getClientFilename()){
                   $updateuser['profile_picture'] = $this->Common->userDocUpload('profile_picture', $profile_picture_data,WWW_ROOT.'img'.DS."user_imgs",$result->id,'Users'); 
                }
                          
                //upload documnts\
                if($address_proof && $address_proof->getClientFilename()){
                    $updateuser['address_proof'] = $this->Common->userDocUpload('address_proof',$address_proof,'', $result->id,'Users');
                }

                if($photo_proof &&  $photo_proof->getClientFilename()){
                    $updateuser['photo_proof'] = $this->Common->userDocUpload('photo_proof',$photo_proof,'', $result->id,'Users');
                }
                if($other_document &&  $other_document->getClientFilename()){
                    $updateuser['other_document'] = $this->Common->userDocUpload('other_document',$other_document,'', $result->id,'Users');
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

                if($id<1){
                    // send mail to user
                    // Please specify your Mail Server - Example: mail.example.com.
                    ini_set("SMTP","riyajaya692@gmail.com");
            
                    // Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
                    ini_set("smtp_port","25");
            
                    // Please specify the return address to use
                    ini_set('sendmail_from', 'riyajaya692@gmail.com');
                    
                    TransportFactory::setConfig('gmail', [
                      'host' => 'ssl://smtp.gmail.com',
                      'port' => 25,
                      'username' => 'riyajaya692@gmail.com',
                      'password' => 'etgtxblbsftaupzd',
                      'className' => 'Smtp'
                    ]);

                    $msg ="Hello ".$post['first_name']."\r\n";
                    $msg .="Welcome to Bnindia application, your account has been genereted successfully,"."\r\n";
                    $msg .= "Superadmin will contact you soon.\r\n";
                    $msg .= 'Thank you,'."\r\n".'Bnindia team';
                    //temparary comment send mail 
                     Email::deliver($post['email'], 'Bnindia application', $msg, ['from' => 'riyajaya692@gmail.com']);
                    // send password to user
                    $msg ="Hello Superadmin \r\n";
                    $msg .="New admin account is created, please check,"."\r\n";
                    $msg .= "User email: ". $post['email']."\r\n";
                    $msg .= 'Thank you,'."\r\n".'Bnindia team';
                    //temparary comment send mail 
                     $send = Email::deliver($this->Auth->user('email'), 'Bnindia application', $msg, ['from' => 'riyajaya692@gmail.com']);

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
    }


    public function approve($user_id)
    {
        $this->loadModel('Users');
        if($user_id>0){ 
            $password = $this->Common->randomPassword();
            $query = $this->Users->query();
            $query->update()
                    ->set(['password'=>$password,'status'=>1])
                    ->where(['id' => $user_id])
                    ->execute();

            // send mail to user
            // Please specify your Mail Server - Example: mail.example.com.
            ini_set("SMTP","riyajaya692@gmail.com");

            // Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
            ini_set("smtp_port","25");

            // Please specify the return address to use
            ini_set('sendmail_from', 'riyajaya692@gmail.com');
            
            TransportFactory::setConfig('gmail', [
              'host' => 'ssl://smtp.gmail.com',
              'port' => 25,
              'username' => 'riyajaya692@gmail.com',
              'password' => 'etgtxblbsftaupzd',
              'className' => 'Smtp'
            ]);
            $user = $this->Users->find('all')->where(['id'=>$user_id])->first();
            $msg ="Hello ".$user->first_name."\r\n";
            $msg .="Welcome to Bnindia application, your account has been genereted successfully,"."\r\n";
            $msg .= "Password:".$password."\r\n";
            $msg .= 'Thank you,'."\r\n".'Bnindia team';
            //temparary comment send mail 
            $send= Email::deliver($user->email, 'Bnindia application', $msg, ['from' => 'riyajaya692@gmail.com']);
             

            if($send){
                echo 1;
            }else{
                //if mail not send revert the changes
                $query->update()
                    ->set(['status'=>0])
                    ->where(['id' => $user_id])
                    ->execute();
                echo 2;
            }
        }
        exit;
    }
}
