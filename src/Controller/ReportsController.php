<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize(); 
        $this->loadComponent('Common');
    }

    function receiptStatement(){
        $this->viewBuilder()->setLayout('admin'); 
 
        $GroupsTable= TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                    'keyField' => 'id',
                                    'valueField' => 'group_code'
                                ])
                 ->where(['status ' => 0,'created_by'=>$this->Auth->user('id')])->toArray();
        $this->set(compact('groups'));
    }

    public function pdf()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();  
            $report = $this->Common->getReceiptStatement($post,$this->Auth->user('id'));  
            $this->viewBuilder()->enableAutoLayout(false);    
            $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
            $this->viewBuilder()->setLayout('admin');
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    // 'render' => 'browser',
                    'download' => true, // This can be omitted if "filename" is specified.
                   'filename' => 'receipt_statement' .'.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );
            //echo '$report<pre>';print_r($report);  exit;
             
            $this->set('branch_name', $this->Auth->user('branch_name'));
            $this->set('report', $report);
        }
    }

     /**
     * instalmentDetails method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function instalmentDetails()
    { 
        $this->viewBuilder()->setLayout('admin');  
        $UsersTable= TableRegistry::get('Users');
        $users = $UsersTable->find('list', [
                                    'keyField' => 'id',
                                     'valueField' => function ($row) {
                                          return $row['first_name'].' '.$row['middle_name'].' '.$row['last_name'];
                                    } ,
                                    'contain' => ['Roles' => function ($q) {
                                            return $q
                                                ->select(['name'])
                                                ->where(['Roles.name' => Configure::read('ROLE_MEMBER') ]);
                                        },     
                                     ], 
                                ])
                 ->where(['status ' => 1,'created_by'=>$this->Auth->User('id')])->toArray();
                 // echo 'users<pre>';print_r($users);exit;
        $this->set(compact('users'));
    } 
    
    function instalmentDetailsPdf(){
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();   
            $report = $this->Common->getInstalmentDetails($post,$this->Auth->user('id'));  
            $user_details = $this->Common->getUserGroupDetails($post,$this->Auth->user('id'));  
            // echo '$post<pre>';print_r($user_details);  exit;
            $this->viewBuilder()->enableAutoLayout(false);    
            $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
            $this->viewBuilder()->setLayout('admin');
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    // 'render' => 'browser',
                    'download' => true, // This can be omitted if "filename" is specified.
                   'filename' => 'instalment_details' .'.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );
            $this->set(compact('report','user_details'));  
        }
    }

     public function subscribersDetails()
    { 
        $this->viewBuilder()->setLayout('admin');  
        $GroupsTable= TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                    'keyField' => 'id',
                                    'valueField' => 'group_code'
                                ])
                 ->where(['status ' => 0,'created_by'=>$this->Auth->user('id')])->toArray();
        $this->set(compact('groups')); 
    } 

    function subscribersDetailsPdf(){
        $report =[];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();   
            // echo '$post<pre>';print_r($post);  exit;
            $report = $this->Common->getSubscribersDetails($post,$this->Auth->user('id'));  
            $group_details = $this->Common->getGroupsDetails($post,$this->Auth->user('id')); 
            $this->viewBuilder()->enableAutoLayout(false);    
            $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
            $this->viewBuilder()->setLayout('admin');
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    // 'render' => 'browser',
                    'download' => true, // This can be omitted if "filename" is specified.
                   'filename' => 'subscribers_details' .'.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );

        }
        $this->set(compact('report','group_details'));
    }

    function auctionsDetails(){
        $this->viewBuilder()->setLayout('admin');  
        $GroupsTable= TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                    'keyField' => 'id',
                                    'valueField' => 'group_code'
                                ])
                 ->where(['status ' => 0,'created_by'=>$this->Auth->user('id')])->toArray();
        $this->set(compact('groups')); 
    }

    function auctionsDetailsPdf(){
        $report =[];
        $group_details=[];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();   
            // echo '$post<pre>';print_r($post);  exit;
            $report = $this->Common->getAuctionsDetails($post,$this->Auth->user('id'));  
            $group_details = $this->Common->getGroupsDetails($post,$this->Auth->user('id'));  
            $this->viewBuilder()->enableAutoLayout(false);    
            $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
            $this->viewBuilder()->setLayout('admin');
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    // 'render' => 'browser',
                    'download' => true, // This can be omitted if "filename" is specified.
                   'filename' => 'auctions_details' .'.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );

        }
        // echo '$group_details<pre>';print_r($group_details);  exit;
        $this->set(compact('report','group_details'));
    }

    function groupsDetails(){
        $this->viewBuilder()->setLayout('admin');  
        $this->set('branch_name', $this->Auth->user('branch_name'));
    }

    function groupsDetailsPdf(){
        $report =[]; 
        if ($this->request->is(['patch', 'post', 'put'])) { 
            $report = $this->Common->getGroupList($this->Auth->user('id'));    
            $this->viewBuilder()->enableAutoLayout(false);    
            $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
            $this->viewBuilder()->setLayout('admin');
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    // 'render' => 'browser',
                    'download' => true, // This can be omitted if "filename" is specified.
                   'filename' => 'groups_details' .'.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );

        }
        // echo '$report<pre>';print_r($report);exit;
        $this->set('branch_name', $this->Auth->user('branch_name'));
        $this->set(compact('report'));
    }
}
