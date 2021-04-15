<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

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
        $this->paginate = [
            'contain' => ['Groups', 'Members'],
        ];
        $payments = $this->paginate($this->Payments);

        $this->set(compact('payments'));
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
                'contain' => ['Groups','Members'],
            ]);
            $payment_member_id =  $payment->user_id;
            $payment_group_id =  $payment->group_id;
            $groups = $this->Common->getMemberGroups($payment_member_id); 
            $members = $this->Common->getGroupMember($payment_group_id);
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
       
        $this->set(compact('payment', 'groups', 'members','payment_member_id','payment_group_id','receipt_no'));

        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
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
         

        $payment= TableRegistry::get('Payments');
        $subquery = $payment->find();

        $subquery->select([
            'pauction_id' => 'Payments.auction_id',
            'premark'=>'Payments.remark',
            'pinstalment_month' => 'Payments.instalment_month',
            'plate_fee' => 'Payments.late_fee',
            'pis_installment_complete ' => 'Payments.is_installment_complete '
        ])->order(['id desc'])->LIMIT(1);

        $auctionTable= TableRegistry::get('Auctions'); 
        $query = $auctionTable->find();
        $payment_info = $query->select(['Auctions.id','Auctions.net_subscription_amount',
                            'remark'=>'p.premark',
                            'instalment_month'=>'p.pinstalment_month',
                            'late_fee'=>'p.plate_fee',
                          ])
               ->join([
                  'table' => '('.$subquery.')',
                  'alias' => 'p',
                  'type' => 'LEFT',
                  'conditions' => 'pauction_id=Auctions.id',
              ]) 
              ->where(['Auctions.id'=>$auction_id])
              ->where(['OR'=>['p.pis_installment_complete !='=>1,'p.pis_installment_complete is '=> NULL]
            ])
              ->first(); 
    // echo '111<pre>';print_r($payment_info);exit;
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
}
