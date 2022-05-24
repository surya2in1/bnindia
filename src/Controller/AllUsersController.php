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
    
}
