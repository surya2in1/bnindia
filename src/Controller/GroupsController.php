<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\I18n\Date;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupsController extends AppController
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
             $output = $this->Groups->GetData();
              // echo '<pre>';print_r($output);exit;
             echo json_encode($output);exit;
        }
        
    }

    function testPaymentsDue(){
        $d1 = new Date("2021-01-31");
        $d2 = new Date("2021-05-21");
        $interval = $d1->diff($d2); 
        $totalMonths  = $interval->m;
        $group_late_fee = 6;
        $net_subscription_amount = 17000;
        $total_late_fee =0;
        $inc = 0;
        
        WHILE ($inc <= $totalMonths){
            IF($inc==0) {
                $late_fee =($net_subscription_amount * $group_late_fee)/100;
            } ELSE {
            	$late_fee = $late_fee+(($late_fee*$group_late_fee)/100);
            }
            
             $total_late_fee = $total_late_fee+$late_fee;
             echo "$totalMonths == $late_fee == $total_late_fee <br/>";
             $inc = $inc + 1;
        
        }
        exit;
    }
    
    /**
     * View method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $group = $this->Groups->get($id, [
            'contain' => [],
        ]);

        $membergroups= TableRegistry::get('MembersGroups');
        $membergroup = $membergroups->find('all', [
            'contain' => [
                             'Users' => function ($q) {
                                return $q
                                    ->select(['name' => $q->func()->concat(['first_name' => 'identifier', ' ','middle_name' => 'identifier', ' ', 'last_name' => 'identifier'])]);
                            },      
                         ],
        ])->where(['MembersGroups.group_id' => $id])->toArray(); 
        $this->set(compact('group','membergroup'));
    }
    /*
    ** add editgroup
    */
     function groupform($id=null){
        $this->viewBuilder()->setLayout('admin');
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }
        if($id>0){
            $group = $this->Groups->get($id, [
                'contain' => [ 
                                'Auctions' => function($q) use ($id) {
                                return $q
                                    ->select(['Auctions.group_id','Auctions.auction_date',
                                                'auction_count' => $q->func()->count('Auctions.id')
                                                ])
                                              ->where(['Auctions.group_id'=>$id]);
                              }, 
                            ],
            ]);       
        }else{
            $group = $this->Groups->newEmptyEntity();
        }
        $auction_count = isset($group['auctions'][0]['auction_count']) && $group['auctions'][0]['auction_count'] > 0 ? $group['auctions'][0]['auction_count'] : 0;
        if($auction_count >0){
            return $this->redirect(['action' => 'index']);
        }
        $user_id = $this->Auth->user('id');
         // echo '<pre>';print_r($group);exit();
        $this->set(compact('group','user_id'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();
            $post['created_by'] = $user_id;
             //convert dates to db field format
            if(strtotime($post['bank_deposite_date']) > 0){
                $post['bank_deposite_date'] = date('Y-m-d',strtotime($post['bank_deposite_date']));
            }
            if(strtotime($post['deposite_maturity_date']) > 0){
                $post['deposite_maturity_date'] = date('Y-m-d',strtotime($post['deposite_maturity_date']));
            }
           echo '<pre>';print_r($post); exit;  
            $group = $this->Groups->patchEntity($group, $post);
            if ($result = $this->Groups->save($group)) {
                echo 1;
            }else{
                 $validationErrors = $group->getErrors();
                //echo '<pre>';print_r($group->getErrors());exit();
                if(isset($validationErrors['group_code']['unique']) && !empty($validationErrors['group_code']['unique'])){
                    echo 'group_code_unique';
                }else{
                    echo 0;
                } 
            } 
            exit;   
        }
     }

     function addGroupMembers(){
        $UsersTable= TableRegistry::get('Users');
        $user = $UsersTable->find('all', [ 
            'contain' => ['Roles' => function ($q) {
                                return $q
                                    ->select(['name']);
                            },     
                         ],
        ])->where(['Users.id' => $this->Auth->user('id') ])->first();
        $role = isset($user->role->name) ? $user->role->name : ''; 
        $config_superadmin_role=Configure::read('ROLE_SUPERADMIN');
        $this->viewBuilder()->setLayout('admin');
        $groups = $this->Groups->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'group_code'
                                    ])
                     ->where(['status' => 1 ])->toArray();
        $this->set(compact('groups','role','config_superadmin_role'));
     }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $MembersGroupsTable = TableRegistry::get('MembersGroups');
        $membergroup = $MembersGroupsTable->find('all')->where(['group_id'=>$id])->first();
        if($membergroup){
            echo 'group_associated_with_members';
        }else{
            $group = $this->Groups->get($id);
            if ($this->Groups->delete($group)) {
                echo 1;
            } else {
                echo 0;
            }
        }
        exit;
    }

    function getGroupMembers($group_id){
            $output = $this->Groups->getGroupMembersData($group_id);
            // echo $group_id.'<pre>';print_r($output);exit;
            echo json_encode($output);exit;
    }

    function getGroupCode($total_number,$created_by,$chit_amount,$group_id){
        $group_code = $this->Groups->get_group_code($total_number,$created_by,$chit_amount,$group_id);
        echo $group_code;exit;
        // $this->Groups->get_group_code($_POST['total_number'],$_POST['created_by'],$_POST['chit_amount']);

    }
}

