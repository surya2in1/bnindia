<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\Mailer\Transport;

/**
 * Agents Controller
 *
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgentsController extends AppController
{
     public function initialize(): void
    {
        parent::initialize(); 
        $this->loadComponent('Common');
    }

    /**
     * Add or edit agent details
     * */
    function agentform($id=null){

        $this->viewBuilder()->setLayout('admin');
       
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        } 

        //get agentdetails
        if($id>0){
            $agent = $this->Agents->get($id, [
                'contain' => [],
            ]); 
        }else{
            $agent = $this->Agents->newEmptyEntity();
        }
        //echo  '<pre>';print_r($agent);exit; 

      
        $this->set(compact('agent'));

        if ($this->request->is(['patch', 'post', 'put'])) {

            $post = $this->request->getData();
            //echo $id.'<pre>';print_r($post);//exit;

            //upload docs
            $address_proof = $post['address_proof']; 
            $pan_card = $post['pan_card'];
            $photo = $post['photo'];
            $educational_proof = $post['educational_proof'];

            //remove unnecessary data for db validation
            unset($post['address_proof']);
            unset($post['pan_card']);
            unset($post['photo']);
            unset($post['educational_proof']); 
 
            $post['created_by'] = $this->Auth->user('id');
            //echo '<pre>';print_r($post);
            $agent = $this->Agents->patchEntity($agent, $post);
            if ($result = $this->Agents->save($agent)) {   
                if($address_proof && $address_proof->getClientFilename()){
                   $updateuser['address_proof'] = $this->Common->userDocUpload('address_proof', $address_proof,WWW_ROOT.'agents_docs'.DS."address_proof",$result->id); 
                }
                          
                //upload documnts\
                if($pan_card && $pan_card->getClientFilename()){
                    $updateuser['pan_card'] = $this->Common->userDocUpload('pan_card',$pan_card,WWW_ROOT.'agents_docs'.DS."pan_card", $result->id);
                }

                if($photo &&  $photo->getClientFilename()){
                    $updateuser['photo'] = $this->Common->userDocUpload('photo',$photo,WWW_ROOT.'agents_docs'.DS."photo", $result->id);
                }
                if($educational_proof &&  $educational_proof->getClientFilename()){
                    $updateuser['educational_proof'] = $this->Common->userDocUpload('educational_proof',$educational_proof,WWW_ROOT.'agents_docs'.DS."educational_proof", $result->id);
                } 
                //update user docs
                if(isset($updateuser)){
                    //update/add customer id
                    // $updateuser['customer_id'] = '00'.$result->id;
                    $usertable = TableRegistry::get("agents");
                    $query = $usertable->query();
                    $query->update()
                            ->set($updateuser)
                            ->where(['id' => $result->id])
                            ->execute();
                }
                 //echo '<pre>';print_r($result);exit;

                // send mail to agent
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
                
                $agent_name = explode(' ', trim($post['name']))[0];
                $msg ="Hello ".$agent_name."\r\n";
                $msg .="Welcome to Bnindia application, your name successfully added."."\r\n";
                $msg .= "Agent code: ". $post['agent_code']."\r\n";
                $msg .= 'Thank you,'."\r\n".'Bnindia team';
                //temparary comment send mail
                //$send = $this->Common->sendmail($post['email'],'Bnindia application',$msg);
                try {
                    Email::deliver($post['email'], 'Bnindia application', $msg, ['from' => 'riyajaya692@gmail.com']);
                    $response = 1;
                } catch (Exception $e) {
                    $response = 0; 
                }
                echo 1;
            }else{
                 $validationErrors = $agent->getErrors();
                 //echo '<pre>';print_r($agent->getErrors());
                echo 0;
            }
            exit;
        }
        
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
             $output = $this->Agents->GetData($this->Auth->user('id')); 
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
        $agent = $this->Agents->get($id, [
            'contain' => [],
            'conditions'=>['status'=>0]
        ]);

        $this->set(compact('agent'));
    }
 

    /**
     * Delete method
     *
     * @param string|null $id Agent id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteAgent($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $UsersTable = TableRegistry::get('Users');
        $userAgent= $UsersTable->find('all')->where(['agent_id'=>$id])->first();
        if($userAgent){
            echo 'agent_associated_with_members';
        }else{
            $agentstable = TableRegistry::get("agents");
            $query = $agentstable->query();
            $query->update()
                    ->set(['status' => 1])
                    ->where(['id' => $id])
                    ->execute();
             echo 1;               
            // $agent = $this->Agents->get($id);
            // if ($this->Agents->delete($agent)) {
            //     echo 1;
            // } else {
            //     echo 0;
            // }
        }
        exit;
    }

    function getAgentCode(){ 
        $post = $this->request->getData();
        $user_data = $this->Auth->user(); 
        // echo 'user_data<pre>';print_r($user_data);exit;
        $agent_code = $this->Agents->get_agent_code($user_data['id'],$post['name'],$user_data['branch_name'],$post['id']);
        echo $agent_code;exit;
     }
}
