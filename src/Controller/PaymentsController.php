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
    //      $fourRandomDigit = mt_rand(1000,9999);
    // echo $fourRandomDigit;    exit;
    
        $this->viewBuilder()->setLayout('admin');
       
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }
 
        $selected_member_groups = []; 
        $payment_member_id =  0;
        $payment_group_id = 0;
        $groups = [];
        if($id>0){
            $payment = $this->Payments->get($id, [
                'contain' => ['Groups','Members'],
            ]);
            $payment_member_id =  $payment->user_id;
            $payment_group_id =  $payment->group_id;
            $groups = $this->Common->getMemberGroups($payment_member_id); 
        }else{
            $payment = $this->Payments->newEmptyEntity();
        }

        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
         
         //Get available Users
        $UsersTable = TableRegistry::get('Users');
        $members = $UsersTable->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'customer_id'
                                        // 'valueField' => function ($e) {
                                        //     return ucwords($e->first_name . ' ' . $e->middle_name . ' ' . $e->last_name);
                                        // }
                                    ])
                     ->contain([
                            'Roles'  => ['conditions' => ['name !=' => 'admin']]
                        ])
                    ->where(['status'=>1])->toArray();
        $this->set(compact('payment', 'groups', 'members','payment_member_id','payment_group_id'));
    }

    // Get selected member group list
    function getGroupsByMemberId(){
        $post = $this->request->getData();
        $member_id = isset($post['member_id']) && $post['member_id']>0  ? $post['member_id'] : 0;
        $selected_member_groups = []; 
        if($member_id>0){ 
            $selected_member_groups = $this->Common->getMemberGroups($member_id);
        }
        echo json_encode($selected_member_groups);exit;
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
