<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Http\Cookie\cookie;
use Cake\I18n\Time;
use Cake\Http\Cookie\CookieCollection;

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
            $name = explode(' ', $postData['fullname']);
            $postData['first_name'] = isset($name[0]) ? $name[0] : '';
            $postData['middle_name'] = isset($name[1]) ? $name[1] : '';
            $postData['last_name'] = isset($name[2]) ? $name[2] : '';
            unset($postData['fullname']);
            unset($postData['agree']);
            unset($postData['rpassword']);
            // echo '<pre>';print_r($this->request->getData());
            // echo 'postData<pre>';print_r($postData);
            // echo 'user<pre>';print_r($user);
            // exit;
             $user = $this->Users->patchEntity($user, $postData);
            if ($this->Users->save($user)) {
                echo 0;
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
}
