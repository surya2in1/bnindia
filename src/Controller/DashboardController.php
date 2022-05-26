<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\I18n\Date;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class DashboardController extends AppController
{
    public function initialize(): void
    {
        parent::initialize(); 
        $this->loadComponent('Common');
    }

    public function index()
    {
    	$this->viewBuilder()->setLayout('admin'); 

        //get total cash
        //echo '<pre>';print_r($this->Auth->user());exit;
        $user = $this->Auth->user();
        $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
        //erro for New Members getMemberCount for role member

        //For Member Check auth role is member then join to members_groups with auth id and created by as user_id
        /*********** getAllSuccessfullTransaction pending******/
        //For user,agent,branch_head and assistant head, get created_by id as branch then use as user_id

        $is_member =0;
        $user_id_param = 0;
        $branch_name = $this->Auth->user('branch_name');
        if($user_role == Configure::read('ROLE_SUPERADMIN')){
            $use_id = -1;
            $branch_name = 'All Branch';
        }else if($user_role == Configure::read('ROLE_MEMBER')){
            $is_member =1;
            $user_id_param = $this->Auth->user('id');
            $use_id = $this->Auth->user('created_by');
        }else if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
            $use_id = $this->Auth->user('created_by');
        }else{
            $use_id = $this->Auth->user('id');
        }
        $this->set('branch_name', $branch_name);

        $total_cash = $this->Common->getAmountByReceivedBy(1,$use_id,$user_id_param);  
        $total_cheque_amount = $this->Common->getAmountByReceivedBy(2,$use_id,$user_id_param); 
        $total_dd_amount = $this->Common->getAmountByReceivedBy(3,$use_id,$user_id_param);  
        $total_amount = $this->Common->getAmountByReceivedBy(0,$use_id,$user_id_param);  

        $succefull_transactions= $this->Common->getAllSuccessfullTransaction($use_id,$user_id_param); 
        $total_groups= $this->Common->getGroupCount($use_id,$user_id_param); 
        $total_members= $this->Common->getMemberCount($use_id,$user_id_param); 
        $total_auctions= $this->Common->getAuctionsCount($use_id,$user_id_param); 
        $total_payments= $this->Common->getPaymentsCount($use_id,$user_id_param); 

        $this->set(compact('total_cash','total_cheque_amount','total_dd_amount','total_amount','succefull_transactions','total_groups','total_members','total_auctions','total_payments'));
        if ($this->request->is('post')) { 
            $GroupsTable = TableRegistry::get('Groups');
            $output = $GroupsTable->GetDashboardData($use_id,$user_id_param);
            // echo '$output <pre>';print_r($output);exit;
             echo json_encode($output);exit;
        }
    }

    function getpaymentdata(){
      $yearly_stats= $this->Common->getAllMonthsCurrentYearPayments($this->Auth->user('id')); 
      echo $yearly_stats;exit;
    }
}
