<?php
declare(strict_types=1);

namespace App\Controller;


use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;
/**
 * OtherPayments Controller
 *
 * @property \App\Model\Table\OtherPaymentsTable $OtherPayments
 * @method \App\Model\Entity\OtherPayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OtherPaymentsController extends AppController
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
             $output = $this->OtherPayments->GetData($this->Auth->user('id'));
             echo json_encode($output);exit;
        }
    }

    /**
     * View method
     *
     * @param string|null $id Other Payment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $payment = $this->OtherPayments->get($id, [
            'contain' => ['PaymentHeads'],
        ]);

        $this->set(compact('payment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    function otherpaymentform($id=null){
         $this->viewBuilder()->setLayout('admin');
       
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }
        if($id>0){
            $payment = $this->OtherPayments->get($id, [
                'contain' => ['PaymentHeads'],
            ]);
        }else{
            $payment = $this->OtherPayments->newEmptyEntity();
        }
        
        //get payment heads
        $PaymentHeadsTable = TableRegistry::get('PaymentHeads');
        $payment_heads = $PaymentHeadsTable->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'payment_head'          
                                    ])->toArray();
       
        //echo '<pre>';print_r($payment);exit;
        $this->set(compact('payment','payment_heads'));
        
        //Submit payment voucher data
        if ($this->request->is('post')) {
          $post = $this->request->getData();
          
          //convert dates to db field format
          $post['date'] = (strtotime($post['date']) > 0) ? date('Y-m-d',strtotime($post['date'])): ''; 
          $post['created_by'] = $this->Auth->user('id');
          //echo '<pre>';print_r($post);exit;
          $OtherPayments = $this->OtherPayments->patchEntity($payment, $post);
          if ($this->OtherPayments->save($OtherPayments)) { 
               echo 1;exit;
          }else{
              $validationErrors = $OtherPayments->getErrors(); 
              echo '<pre>';print_r($validationErrors);exit;
              echo 0;exit;
          }
        }
    } 
    public function otherpaymentform_bk()
    {
        $this->viewBuilder()->setLayout('admin');
        $otherPayment = $this->OtherPayments->newEmptyEntity();
        if ($this->request->is('post')) {
            $otherPayment = $this->OtherPayments->patchEntity($otherPayment, $this->request->getData());
            if ($this->OtherPayments->save($otherPayment)) {
                $this->Flash->success(__('The other payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The other payment could not be saved. Please, try again.'));
        }
        $paymentHeads = $this->OtherPayments->PaymentHeads->find('list', ['limit' => 200]);
        $users = $this->OtherPayments->Users->find('list', ['limit' => 200]);
        $this->set(compact('otherPayment', 'paymentHeads', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Other Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $otherPayment = $this->OtherPayments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $otherPayment = $this->OtherPayments->patchEntity($otherPayment, $this->request->getData());
            if ($this->OtherPayments->save($otherPayment)) {
                $this->Flash->success(__('The other payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The other payment could not be saved. Please, try again.'));
        }
        $paymentHeads = $this->OtherPayments->PaymentHeads->find('list', ['limit' => 200]);
        $users = $this->OtherPayments->Users->find('list', ['limit' => 200]);
        $this->set(compact('otherPayment', 'paymentHeads', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Other Payment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */  
    function deletePayment($payment_id){
        $this->request->allowMethod(['get', 'delete']); 
        $otherPayment = $this->OtherPayments->get($payment_id); 
        if ($this->OtherPayments->delete($otherPayment)) { 
            echo 1;
        } else {
            echo 0;
        } 
        exit();
    }
}
