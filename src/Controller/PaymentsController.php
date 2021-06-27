<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize(); 
        $this->loadComponent('Common');
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
             $output = $this->Payments->GetData();
             echo json_encode($output);exit;
        }
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => ['Groups', 'Members'],
        ]);

        $this->set(compact('payment'));
    }

    /**
     * Add/Edit method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function paymentform($id=null)
    {
        $this->viewBuilder()->setLayout('admin');
       
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }
 
        $selected_member_groups = []; 
        $payment_member_id =  0;
        $payment_group_id = 0;
        $groups = [];
        $receipt_no = 1;
        $members = [];
        if($id>0){
            $payment = $this->Payments->get($id, [
                'contain' => ['Groups'],
            ]);
            $payment_member_id =  $payment->user_id;
            $payment_group_id =  $payment->group_id;
            $groups = $this->Common->getMemberGroups($payment_member_id);  
        }else{
            $payment_receipt_no = $this->Payments->find()->count();
            $receipt_no = $payment_receipt_no +1;
            $payment = $this->Payments->newEmptyEntity();
        }

        //Get available Users
        $AuctionsTable = TableRegistry::get('Auctions');
        $groups = $AuctionsTable->find('list', [
                                        'keyField' => 'group_id',
                                        'valueField' => function ($row) {
                                            return $row->group->group_code;
                                        }          
                                    ])
                     ->contain([
                            'Groups'  
                        ])
                    ->group(['Auctions.group_id'])->toArray();
        // echo '$groups<pre>';print_r($groups);exit;
       
        $this->set(compact('payment', 'groups', 'payment_member_id','payment_group_id','receipt_no'));

        if ($this->request->is('post')) {
          $post = $this->request->getData();
          
          //convert dates to db field format
          $post['due_date'] = (strtotime($post['due_date']) > 0) ? date('Y-m-d',strtotime($post['due_date'])): '';
          $post['date'] = (strtotime($post['date']) > 0) ? date('Y-m-d',strtotime($post['date'])): '';
        
          $post['cheque_date'] = (strtotime($post['cheque_date']) > 0) ? date('Y-m-d',strtotime($post['cheque_date'])): '';
          
          $post['direct_debit_date'] = (strtotime($post['direct_debit_date']) > 0) ? date('Y-m-d',strtotime($post['direct_debit_date'])): '';

          $post['pending_amount'] = $post['remark'];
          if($post['remark'] < 1){
            $post['is_installment_complete'] = 1;
          }
          //SELECT money_notes->'$."2000".val' as code4 FROM payments
    
          //=echo '<pre>';print_r($post);exit;
          $payment = $this->Payments->patchEntity($payment, $post, ['validate' => 'receivedby']);
          if ($this->Payments->save($payment)) {
               echo 1;exit;
          }else{
              $validationErrors = $payment->getErrors(); 
              echo 0;exit;
          }
        }
    }

    // Get selected group members list
    function getMembersByGroupId(){
        $post = $this->request->getData();
        $group_id = isset($post['group_id']) && $post['group_id']>0  ? $post['group_id'] : 0;
        $selected_group_members = []; 
        if($group_id>0){ 
            $selected_group_members = $this->Common->getGroupMember($group_id);
        }
        echo json_encode($selected_group_members);exit;
    }

    // Get installment no by selecting group and member
    function getInstalmentNo(){
        $post = $this->request->getData();
        $group_id = isset($post['group_id']) && $post['group_id']>0  ? $post['group_id'] : 0;
        $member_id = isset($post['member_id']) && $post['member_id']>0  ? $post['member_id'] : 0;
        $selected_instalment_nos = []; 
        if($group_id>0  && $member_id > 0){ 
            $selected_instalment_nos = $this->Common->getInstalmentNoList($group_id,$member_id);
        }
        echo json_encode($selected_instalment_nos);exit;
    }

    function getPaymentsInfo(){
        $post = $this->request->getData();
        $auction_id = isset($post['auction_id']) && $post['auction_id']>0  ? $post['auction_id'] : 0;
        $user_id = isset($post['user_id']) && $post['user_id']>0  ? $post['user_id'] : 0;
        
        $payment= TableRegistry::get('Payments');
        $subquery = $payment->find();
        $subquery->select([
            'pauction_id' => 'Payments.auction_id',
            'puser_id' => 'Payments.user_id',
            'premark'=>'Payments.remark',
            'pinstalment_month' => 'Payments.instalment_month',
            'plate_fee' => 'Payments.late_fee',
            'pis_installment_complete' => 'Payments.is_installment_complete',
            'ptotal_amount' => 'Payments.total_amount',
            'ppending_amount' => 'Payments.pending_amount',
            'premaining_late_fee'=> 'Payments.remaining_late_fee',
            'pis_late_fee_clear' => 'Payments.is_late_fee_clear',
            'psubscription_amount' => 'Payments.subscription_amount',
            'premaining_subscription_amount' => 'Payments.remaining_subscription_amount'
        ]) 
        ->where(['Payments.auction_id'=>$auction_id, 'Payments.user_id' => $user_id])
        ->order(['id desc'])->LIMIT(1);

        $auctionTable= TableRegistry::get('Auctions'); 
        $query = $auctionTable->find();
        $conditions = array(
               'AND' => array(
                   ['Auctions.id'=>$auction_id],
                   array(
                     'OR'=>array(
                        ['p.puser_id'=>$user_id],
                        ['p.puser_id is '=> NULL]
                     )
                   ),
                   array(
                     'OR'=>array(
                        ['p.pis_installment_complete !='=>1],
                        ['p.pis_installment_complete is '=> NULL]
                     )
                  ),
               )
            );
        
        $payment_info = $query->select(['Auctions.id','Auctions.net_subscription_amount',
                            'Auctions.auction_date',
                            'remark'=>'p.premark',
                            'instalment_month'=>'p.pinstalment_month',
                            'late_fee'=>'p.plate_fee',
                            'total_amount'=>'p.ptotal_amount',
                            'pending_amount'=>'p.ppending_amount',
                            'premaining_late_fee' => 'premaining_late_fee',
                            'pis_late_fee_clear' => 'pis_late_fee_clear',
                            'psubscription_amount' => 'psubscription_amount',
                            //'premaining_subscription_amount' => 'premaining_subscription_amount',
                            'premaining_subscription_amount' => "(CASE WHEN premaining_subscription_amount > 0 THEN premaining_subscription_amount ELSE Auctions.net_subscription_amount END)"
                          ])
               ->join([
                  'table' => '('.$subquery.')',
                  'alias' => 'p',
                  'type' => 'LEFT',
                  'conditions' => 'pauction_id=Auctions.id AND puser_id='.$user_id,
              ]) 
               ->where($conditions)->first();
     //echo '111<pre>';print_r($payment_info);exit;
              echo json_encode($payment_info);exit;
    }


    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $groups = $this->Payments->Groups->find('list', ['limit' => 200]);
        $members = $this->Payments->Members->find('list', ['limit' => 200]);
        $this->set(compact('payment', 'groups', 'members'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    function getDuePayments($group_id=0,$member_id=0){ 
      $output = $this->Payments->getDuePayments($group_id,$member_id);
      echo json_encode($output);exit;
    }

    //Get print receipt data
    /*
      * receipt_no
      * payment_date
      * area_code,cust_code
      * member_name
      * sub_rs
      * cash/cheque/dd
      * date 
      * transaction_no
      * drown_on

      * group_code
      * ticket_no
      * instalment_no
      * instalment_month
      * subsciption_rs
      * late_fee
      * remark
      * total
      * group register no
      * profile address, city, state,branch    
      */
    public function receipt($payment_id)
    { 
      $this->viewBuilder()->setLayout('print');   
       $receipt_data = $this->Payments->get($payment_id, [
                'contain' => [ 
                                'Groups' => function($q) use ($payment_id) {
                                  return $q->select(['Groups.group_code','Groups.gov_reg_no'])
                                        ->contain(['Users' => function($q) {
                                          return $q->select(['Users.address','Users.city','Users.state','Users.branch_name','Users.area_code','Users.pin_code']);
                                        }, 
                                  ]);
                                }, 
                                'MembersGroups' => function($q) use ($payment_id) {
                                  return $q->select(['MembersGroups.id','MembersGroups.group_id','MembersGroups.user_id','MembersGroups.temp_customer_id','MembersGroups.ticket_no']);
                                } 
                            ]
            ]);       
       //echo '<pre>';print_r($receipt_data);exit;
      $payment_user_id = ($receipt_data->user_id && $receipt_data->user_id > 0 ) ? $receipt_data->user_id : 0;
      $payment_group_id = ($receipt_data->group_id && $receipt_data->group_id > 0) ? $receipt_data->group_id : 0;
      
      //Get all months due amount 
      $all_months_due_amount = $this->Payments->getAllMonthsDueAmount($payment_user_id,$payment_group_id);
      
      $UsersTable = TableRegistry::get('Users');
      $member =  $UsersTable->find();
      $memberInfo = $member->select(['name' => $member->func()->concat(['first_name' => 'identifier', ' ','middle_name' => 'identifier', ' ', 'last_name' => 'identifier']),
        'Users.area_code'  
        ])->where(['id' => $receipt_data->user_id])->first();  

       // echo '<pre>';print_r($memberInfo);exit;   

      //Reg.Off.H.No.1727/2, Shivajinager, Tal.Karmala, Dist.Solapur Pin- 413 203
      $branch_address = isset($receipt_data->group->user->address) ? $receipt_data->group->user->address : '';
      $branch_address .= isset($receipt_data->group->user->branch_name) ? ', '.$receipt_data->group->user->branch_name : '';
      // $branch_address .= isset($receipt_data->group->user->city) ? ', '.$receipt_data->group->user->city : '';
      $branch_address .= isset($receipt_data->group->user->state) ? ', '.$receipt_data->group->user->state : '';
      $branch_address .= isset($receipt_data->group->user->pin_code) && ($receipt_data->group->user->pin_code > 0)  ? ' Pin- '.$receipt_data->group->user->pin_code: '';
      $branch_address = trim($branch_address,",");


      $receipt_date=''; 
      if(isset($receipt_data->date) && !empty($receipt_data->date)){
          $FrozenDateObj = new FrozenDate($receipt_data->date); 
          $receipt_date = $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
      }
      
      $received_by = '';
      $received_by_dt = '';  
      $received_by_tran_no = '';
      $received_by_drown_on = '';
      if(isset($receipt_data->received_by) && ($receipt_data->received_by== 1)){
          $received_by = 'Cash';
          $received_by_dt = $receipt_date;
      }
      if(isset($receipt_data->received_by) && ($receipt_data->received_by== 2)){
          $received_by = 'Cheque No. - '.$receipt_data->cheque_no;
          if(isset($receipt_data->cheque_date) && !empty($receipt_data->cheque_date)){
            $FrozenDateObj = new FrozenDate($receipt_data->cheque_date); 
            $received_by_dt = $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
          } 
          $received_by_drown_on =  $receipt_data->cheque_drown_on;
      }
      if(isset($receipt_data->received_by) && ($receipt_data->received_by== 3)){
          $received_by = 'D.D.';
          if(isset($receipt_data->direct_debit_date) && !empty($receipt_data->direct_debit_date)){
            $FrozenDateObj = new FrozenDate($receipt_data->direct_debit_date); 
            $received_by_dt = $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
          } 
          $received_by_tran_no = $receipt_data->direct_debit_transaction_no;
      }
      $this->set(compact('receipt_data','receipt_date','received_by','received_by_dt','received_by_tran_no','received_by_drown_on','memberInfo','branch_address','all_months_due_amount'));
    }
    
    // function paymentvoucher($id=null){
    //      $this->viewBuilder()->setLayout('admin');
       
    //     if(isset($_POST['id']) && ($_POST['id'] > 0)){
    //         $id =  $_POST['id'];
    //     }
        
    //     $UsersTable = TableRegistry::get('Users'); 
    //     $user = $UsersTable->find('all', [ 
    //         'contain' => ['Roles' => function ($q) {
    //                             return $q
    //                                 ->select(['name'])
    //                                 ->where(['Roles.name' => Configure::read('ROLE_SUPERADMIN') ]);
    //                         },     
    //                      ],
    //     ])->first();
    //     $foreman_commission_in_percent = ($user->foreman_commission_in_percent) ? $user->foreman_commission_in_percent : 5;
        
    //     $selected_member_groups = []; 
    //     $payment_member_id =  0;
    //     $payment_group_id = 0;
    //     $groups = [];
    //     $receipt_no = 1;
    //     $members = [];
    //     if($id>0){
    //         $payment = $this->Payments->get($id, [
    //             'contain' => ['Groups'],
    //         ]);
    //         $payment_member_id =  $payment->user_id;
    //         $payment_group_id =  $payment->group_id;
    //         $groups = $this->Common->getMemberGroups($payment_member_id);  
    //     }else{
    //         $payment_receipt_no = $this->Payments->find()->count();
    //         $receipt_no = $payment_receipt_no +1;
    //         $payment = $this->Payments->newEmptyEntity();
    //     }

    //     //Get available Users
    //     $AuctionsTable = TableRegistry::get('Auctions');
    //     $groups = $AuctionsTable->find('list', [
    //                                     'keyField' => 'group_id',
    //                                     'valueField' => function ($row) {
    //                                         return $row->group->group_code;
    //                                     }          
    //                                 ])
    //                  ->contain([
    //                         'Groups'  
    //                     ])
    //                 ->group(['Auctions.group_id'])->toArray();
    //     // echo '$groups<pre>';print_r($groups);exit;
       
    //     $this->set(compact('payment', 'groups', 'payment_member_id','payment_group_id','receipt_no','foreman_commission_in_percent'));
    // }
    
     // Get selected group auctions list
    function getAuctionsByGroupId(){
        $post = $this->request->getData();
        $group_id = isset($post['group_id']) && $post['group_id']>0  ? $post['group_id'] : 0;
        $payment_voucher_id = isset($post['payment_voucher_id']) && $post['payment_voucher_id']>0  ? $post['payment_voucher_id'] : 0;
        $selected_group_members = []; 
        if($group_id>0){ 
            $selected_group_members = $this->Common->getPaymentVoucherGroupAuctions($group_id,$payment_voucher_id);
        }
        echo json_encode($selected_group_members);exit;
    }
    
    function getAuctionDetails(){
        $post = $this->request->getData();
        $auction_id = isset($post['auction_id']) && $post['auction_id']>0  ? $post['auction_id'] : 0;
        $auction_details = $this->Common->getAuctionDetails($auction_id);
        echo json_encode($auction_details);exit;
    }
}
