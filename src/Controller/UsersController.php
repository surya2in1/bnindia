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
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
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
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
                // TransportFactory::setConfig('mailtrap', [
                //   'host' => 'smtp.mailtrap.io',
                //   'port' => 2525,
                //   'username' => '8f7ca86b8c979f',
                //   'password' => '006f3da61f5887',
                //   'className' => 'Smtp'
                // ]);

                TransportFactory::setConfig('gmail', [
                  'host' => 'ssl://smtp.gmail.com',
                  'port' => 25,
                  'username' => 'riyajaya692@gmail.com',
                  'password' => 'jayshri21',
                  'className' => 'Smtp'
                ]);
                
                $msg= 'Hello '.$email.'<br/> Please click link below to reset your password<br/><br/><a href="http://localhost/bnindia/resetpassword/'.$mytocken.'">Reset Password</a>';
                
                try {
                    Email::deliver($email, 'Please confirm your reset password', $msg, ['from' => 'votreidentifiant@gmail.com']);
                    $response = 1;
                } catch (Exception $e) {
                    $response = 0;
                }

                // $email = new Email('default');
                // $email->transport('mailtrap');
                // $email->emailFormat('html');
                // $email->from('jayshris22@gmail.com','Jayshri');
                // $email->subject('Please confirm your reset password');
                // $email->to($email);
                // $email->send($msg);
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
        //echo '<pre>';print_r($user);exit();
        $this->set('user',$user);
        if ($this->request->is(['patch', 'post', 'put'])) {
            echo '<pre>';print_r($this->request->getData());
            $post = $this->request->getData();
            if(strtotime($post['date_of_birth']) > 0){
                $post['date_of_birth'] = date('Y-m-d',strtotime($post['date_of_birth']));
            }
            if(strtotime($post['nominee_dob']) > 0){
                $post['nominee_dob'] = date('Y-m-d',strtotime($post['nominee_dob']));
            }
            $profile_picture_data = $post['profile_picture'];
            unset($post['profile_picture']);
            $user = $this->Users->patchEntity($user, $post);
            $validationErrors = $user->getErrors();
            //echo 'validationErrors <pre>';print_r($validationErrors);exit;
            if(empty($validationErrors)){
                $profile_picture = $profile_picture_data;
                $name = $profile_picture->getClientFilename();
                if($name){
                    $sffledStr= str_shuffle('abscdefghij');
                    $uniqueString = md5(time().$sffledStr);
                    $type = $profile_picture->getClientMediaType();
                    $size = $profile_picture->getSize();
                    $tmpName = $profile_picture->getStream()->getMetadata('uri');
                    if($name){
                        //get exsiting image from db 
                        $existing_pic = $user->profile_picture;
                        if($existing_pic){
                            unlink( WWW_ROOT.'img'.DS."user_imgs".DS.$existing_pic);
                        }
                        $targetPath = WWW_ROOT.'img'.DS."user_imgs".DS.$uniqueString.'_'.$name;
                        $profile_picture->moveTo($targetPath);
                        $user->profile_picture = $uniqueString.'_'.$name;
                    }

                }
                          
            }
           // echo 'user <pre>';print_r($user);exit;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'personalinfo']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }
}
