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
        $this->set('branch_name', $this->Auth->user('branch_name'));

        //get total cash
        $total_cash = $this->Common->getAmountByReceivedBy(1,$this->Auth->user('id'));  
        $total_cheque_amount = $this->Common->getAmountByReceivedBy(2,$this->Auth->user('id')); 
        $total_dd_amount = $this->Common->getAmountByReceivedBy(3,$this->Auth->user('id'));  
        $total_amount = $this->Common->getAmountByReceivedBy(0,$this->Auth->user('id'));  

        $yearly_stats= $this->Common->getAllMonthsCurrentYearPayments($this->Auth->user('id'));  
        
        $succefull_transactions= $this->Common->getAllSuccessfullTransaction($this->Auth->user('id')); 
        $this->set(compact('total_cash','total_cheque_amount','total_dd_amount','total_amount','yearly_stats','succefull_transactions'));
        if ($this->request->is('post')) { 
            $GroupsTable = TableRegistry::get('Groups');
            $output = $GroupsTable->GetDashboardData($this->Auth->user('id'));
            // echo '$output <pre>';print_r($output);exit;
             echo json_encode($output);exit;
        }
    }
}
