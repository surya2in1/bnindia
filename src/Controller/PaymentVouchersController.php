<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;

/**
 * PaymentVouchersController Controller
 *
 * @property \App\Model\Table\PaymentVouchersTable $paymentVouchers
 * @method \App\Model\Entity\PaymentVouchers[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentVouchersController extends AppController
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
             $output = $this->PaymentVouchers->GetData();
             echo json_encode($output);exit;
        }
    }
    
    
    function paymentvoucherform($id=null){
         $this->viewBuilder()->setLayout('admin');
       
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }
        if($id>0){
            $payment = $this->PaymentVouchers->get($id, [
                'contain' => ['Groups'],
            ]);
            $where_Conditions['OR'] = [
                                    'Auctions.is_payment_done' => 0,
                                    'p.id' => $id
                                ];
        }else{
            $payment = $this->PaymentVouchers->newEmptyEntity();
            $where_Conditions= ['Auctions.is_payment_done'=>0];
        }
        
         //Get available Auctions
        $AuctionsTable = TableRegistry::get('Auctions'); 
 
        $query = $AuctionsTable->find();     
        $agroups = $query->select(['Auctions.group_id','g.group_code'])
             ->join([
                'table' => 'payment_vouchers',
                'alias' => 'p',
                'type' => 'LEFT',
                'conditions' =>'p.auction_id = Auctions.id',
            ])
             ->join([
                'table' => 'groups',
                'alias' => 'g',
                'type' => 'LEFT',
                'conditions' => 'g.id = Auctions.group_id',
            ])
            ->where($where_Conditions)
            ->group('Auctions.group_id')
            ->toArray();  
        $groups = [];
        if(!empty($agroups)){
            foreach($agroups as $group){
                $groups[$group->group_id]  = $group->g['group_code'];
            }
        }    
        
        $this->set(compact('payment','groups'));
        
        //Submit payment voucher data
        if ($this->request->is('post')) {
          $post = $this->request->getData();
          //echo '$post <pre>';print_r($post);exit;
        
          //convert dates to db field format
          $post['date'] = (strtotime($post['date']) > 0) ? date('Y-m-d',strtotime($post['date'])): '';
          $post['auction_date'] = (strtotime($post['auction_date']) > 0) ? date('Y-m-d',strtotime($post['auction_date'])): '';
         
          // echo '<pre>';print_r($post);exit;
          $PaymentVouchers = $this->PaymentVouchers->patchEntity($payment, $post);
          if ($this->PaymentVouchers->save($PaymentVouchers)) {
            $auctionstable = TableRegistry::get("Auctions"); 
            
            //update old  auction id is_pa-done payment
            if(isset($post['payment_auction_id']) && $post['payment_auction_id'] > 0){ 
                $query = $auctionstable->query();
                $query->update()
                    ->set(['is_payment_done'=>0])
                    ->where(['id' => $post['payment_auction_id']])
                    ->execute();  
            } 
            $query = $auctionstable->query();
            $query->update()
                    ->set(['is_payment_done'=>1])
                    ->where(['id' => $post['auction_id']])
                    ->execute();
            echo 1;exit;
          }else{
              $validationErrors = $PaymentVouchers->getErrors(); 
              //echo '<pre>';print_r($validationErrors);exit;
              echo 0;exit;
          }
        }   
    }
    
    function view($id=null){
         $this->viewBuilder()->setLayout('admin');
       
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }
        if($id>0){
            $payment = $this->PaymentVouchers->get($id, [
                'contain' => [
                    'Groups' => function($q) {
                                return $q
                                    ->select(['id','group_code']);
                            },
                     'Users' => function($q) {
                                return $q
                                    ->select(['id','name' => $q->func()->concat(['UPPER(SUBSTRING(Users.first_name, 1, 1)), LOWER(SUBSTRING(Users.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(middle_name, 1, 1)), LOWER(SUBSTRING(middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(last_name, 1, 1)), LOWER(SUBSTRING(last_name, 2))' => 'identifier'])]);
                            },   
                     'Auctions' => function($q) {
                                return $q
                                    ->select(['id','auction_no']);
                            },        
                    ],
            ]); 
        } 
        //echo $payment->auction_date.' / $payment<pre>';print_r($payment);exit;
        $this->set(compact('payment'));
    }
    
    function deletePayment($payment_id){
        $this->request->allowMethod(['get', 'delete']); 
        $paymentVoucher = $this->PaymentVouchers->get($payment_id);
        $payment_auction_id=$paymentVoucher->auction_id;
        if ($this->PaymentVouchers->delete($paymentVoucher)) {
            $auctionstable = TableRegistry::get("Auctions"); 
            $query = $auctionstable->query();
            $query->update()
                    ->set(['is_payment_done'=>0])
                    ->where(['id' => $payment_auction_id])
                    ->execute();
            echo 1;
        } else {
            echo 0;
        } 
        exit();
    }
}
