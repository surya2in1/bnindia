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
        $groups = $this->getGroupsRoleWise();
        $this->set(compact('groups'));
    }

    function getGroupsRoleWise(){
        $user = $this->Auth->user();
        $user_role = isset($user['role']['name']) ? $user['role']['name'] : '';
        // $conditions['status']= 0;
        if($user['role']['name'] == Configure::read('ROLE_ADMIN')){
            $conditions['created_by']=$this->Auth->user('id'); 
        }

        if($user_role == Configure::read('ROLE_MEMBER')){ 
            //Get all groups of current member
            $member_groups =$this->Common->getAllGroupMembers($this->Auth->user('id'),$this->Auth->user('created_by'));
            $member_group_ids = array_column($member_groups, 'group_id');

            // echo '<pre>';print_r($member_group_ids);exit;
            $conditions['id IN ']=!empty($member_group_ids) ? $member_group_ids : [0];
            $conditions['created_by'] = $this->Auth->user('created_by'); 
        }
        if($user_role == Configure::read('ROLE_AGENT')){ 
            //Get all groups of current member
            $member_groups =$this->Common->getAgentMemberGroups($this->Auth->user('created_by'),$this->Auth->user('agent_id'));
            $member_group_ids = array_column($member_groups, 'group_id');

            // echo '<pre>';print_r($member_group_ids);exit;
            $conditions['id IN ']=!empty($member_group_ids) ? $member_group_ids : [0];
            $conditions['created_by'] = $this->Auth->user('created_by'); 
        }
        if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
           $conditions['created_by'] = $this->Auth->user('created_by'); 
        } 

        $GroupsTable= TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                    'keyField' => 'id',
                                    'valueField' => 'group_code'
                                ])
                 ->where($conditions)->toArray();
        return $groups;
    }

    function getMembers(){
         $user_id=0;$created_by=0;
        $user = $this->Auth->user();
        $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
        if($user['role']['name'] == Configure::read('ROLE_ADMIN')){
            $created_by=$this->Auth->user('id');
        }

        if($user_role == Configure::read('ROLE_MEMBER')){ 
            $user_id=$this->Auth->user('id');
            $created_by=$this->Auth->user('created_by');
        }
        if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
           $created_by=$this->Auth->user('created_by');
        } 
        $group_members = $this->Common->getAllGroupMembersForReceipt($user_id,$created_by,$user_role,$this->Auth->user('agent_id'));
        echo json_encode($group_members);exit;
    }
    public function pdf()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();  
            $user = $this->Auth->user();
            $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
            $report = $this->Common->getReceiptStatement($post,$this->Auth->user('id'),$user_role,$this->Auth->user('created_by'));  
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
            $this->set('post_data', $post);
        }
    }

     /**
     * instalmentDetails method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function instalmentDetails()
    { 
        $user_id=0;$created_by=0;
        $user = $this->Auth->user();
        $user_role = isset($user['role']['name']) ? $user['role']['name'] : '';
        $conditions['status']= 1;
        if($user['role']['name'] == Configure::read('ROLE_ADMIN')){
            $conditions['Users.created_by']=$this->Auth->user('id'); 
        }

        if($user_role == Configure::read('ROLE_MEMBER')){ 
            $conditions['Users.id']=$this->Auth->user('id');
            $conditions['Users.created_by'] = $this->Auth->user('created_by'); 
        }

        if($user_role == Configure::read('ROLE_AGENT')){ 
            $conditions['Users.agent_id']=$this->Auth->user('agent_id');
            $conditions['Users.created_by'] = $this->Auth->user('created_by'); 
        }

        if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
           $conditions['Users.created_by'] = $this->Auth->user('created_by'); 
        } 

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
                 ->where($conditions)->order(['Users.first_name  asc'])->toArray();
                 // echo 'users<pre>';print_r($users);exit;
        $this->set(compact('users'));
    } 
    
    function instalmentDetailsPdf(){
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post_data = $this->request->getData();   
            $user = $this->Auth->user();
            $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
            $report = $this->Common->getInstalmentDetails($post_data,$this->Auth->user('id'),$user_role,$this->Auth->user('created_by'));  
            $user_details = $this->Common->getUserGroupDetails($post_data,$this->Auth->user('id'),$user_role,$this->Auth->user('created_by'));  
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
            $this->set(compact('report','user_details','post_data'));  
        }
    }

     public function subscribersDetails()
    { 
        $this->viewBuilder()->setLayout('admin');  
        $groups = $this->getGroupsRoleWise(); 
        $this->set(compact('groups')); 
    } 

    function subscribersDetailsPdf(){
        $report =[];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();   
            // echo '$post<pre>';print_r($post);  exit;
            $user = $this->Auth->user();
            $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 

            $report = $this->Common->getSubscribersDetails($post,$this->Auth->user('id'),$user_role, $this->Auth->user('created_by'));  
            $group_details = $this->Common->getGroupsDetails($post,$this->Auth->user('id'),$user_role, $this->Auth->user('created_by')); 
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
        $groups = $this->getGroupsRoleWise();
        $this->set(compact('groups'));
    }

    function auctionsDetailsPdf(){
        $report =[];
        $group_details=[];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post_data = $this->request->getData();   
            $user = $this->Auth->user();
            $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 

            // echo '$post<pre>';print_r($post_data);  exit;
            $report = $this->Common->getAuctionsDetails($post_data,$this->Auth->user('id'),$user_role, $this->Auth->user('created_by'));  
            $group_details = $this->Common->getGroupsDetails($post_data,$this->Auth->user('id'),$user_role, $this->Auth->user('created_by'));  
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
        $this->set(compact('report','group_details','post_data'));
    }

    function groupsDetails(){
        $this->viewBuilder()->setLayout('admin');  
        $UsersTable= TableRegistry::get('Users');

        $user = $this->Auth->user();
        $user_role = isset($user['role']['name']) ? $user['role']['name'] : '';
        $conditions['status']= 1;
        if($user['role']['name'] == Configure::read('ROLE_ADMIN')){
            $conditions['Users.id']=$this->Auth->user('id'); 
        }

        if($user_role == Configure::read('ROLE_MEMBER')){  
            $conditions['Users.id'] = $this->Auth->user('created_by'); 
        }
        if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
           $conditions['Users.id'] = $this->Auth->user('created_by'); 
        } 

        $branch_names = $UsersTable->find('list', [
                                    'keyField' => 'id',
                                     'valueField' => function ($row) {
                                          return $row['branch_name'];
                                    } ,
                                    'contain' => ['Roles' => function ($q) {
                                            return $q
                                                ->select(['name'])
                                                ->where(['Roles.name' => Configure::read('ROLE_ADMIN') ]);
                                        },     
                                     ], 
                                ])
                 ->where($conditions)->order(['Users.branch_name asc'])->toArray();
                 // echo 'branch_names<pre>';print_r($branch_names);exit; 
        $this->set('branch_names', $branch_names);
    }

    function groupsDetailsPdf(){
        $report =[]; 
        if ($this->request->is(['patch', 'post', 'put'])) { 
            $user = $this->Auth->user();
            $user_role = isset($user['role']['name']) ? $user['role']['name'] : '';
            if($user['role']['name'] == Configure::read('ROLE_AGENT')){
                $report = $this->Common->getAgentMemberGroupList( $this->request->getData('branch_name'),$this->Auth->user('agent_id'));    
            }elseif($user['role']['name'] == Configure::read('ROLE_MEMBER')){
                $report = $this->Common->getMemberGroupList( $this->request->getData('branch_name'),$this->Auth->user('id'));    
            }else{
                $report = $this->Common->getGroupList( $this->request->getData('branch_name'));    
            }

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

    function vacuntMembersDetailsPdf(){
        $user = $this->Auth->user();
        $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
   
        //get groups of only that member for member role //refer getMemberCount
        $report = $this->Common->getVacantMemberDetails($this->Auth->user('id'),0,$user_role, $this->Auth->user('created_by'));    
        $this->viewBuilder()->enableAutoLayout(false);    
        $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
        $this->viewBuilder()->setLayout('admin');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
               'filename' => 'vaccant_member_report' .'.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('branch_name', $this->Auth->user('branch_name'));
        $this->set(compact('report'));
    }


    function formanCommissionDetails()
    { 
        $this->viewBuilder()->setLayout('admin');  
        $groups = $this->getGroupsRoleWise();
        $this->set(compact('groups'));
    } 

    function formanCommissionDetailsPdf(){
         $user = $this->Auth->user();
         $user_role = isset($user['role']['name']) ? $user['role']['name'] : '';  

        $post_data=$this->request->getData();
        $report = $this->Common->getFormanCommissionDetailsPdf($post_data,$this->Auth->user('id'),$user_role,$this->Auth->user('created_by'));    
        $this->viewBuilder()->enableAutoLayout(false);    
        $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
        $this->viewBuilder()->setLayout('admin');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
               'filename' => 'forman_commission_details_report' .'.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('branch_name', $this->Auth->user('branch_name'));
        $this->set(compact('report','post_data'));
    }

    function prizedPaymentSubscriberDetails()
    { 
        $this->viewBuilder()->setLayout('admin');  
        $groups = $this->getGroupsRoleWise();
        $this->set(compact('groups'));
    } 

    function prizedPaymentSubscriberDetailsPdf(){
        $user = $this->Auth->user();
         $user_role = isset($user['role']['name']) ? $user['role']['name'] : '';  

        $post_data=$this->request->getData();
        $report = $this->Common->getFormanCommissionDetailsPdf($post_data,$this->Auth->user('id'),$user_role,$this->Auth->user('created_by'));    
        $this->viewBuilder()->enableAutoLayout(false);    
        $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
        $this->viewBuilder()->setLayout('admin');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
               'filename' => 'prized_payment_subscriber_report' .'.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $this->set('branch_name', $this->Auth->user('branch_name'));
        $this->set(compact('report','post_data'));
    }

     function transferedSubscriberDetails()
    { 
        $this->viewBuilder()->setLayout('admin');  
        $groups = $this->getGroupsRoleWise();
        $this->set(compact('groups'));
    } 

    function transferedSubscriberDetailsPdf(){
         $user = $this->Auth->user();
         $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
        $post_data=$this->request->getData();
        $report = $this->Common->getTransferedSubscriberDetails($post_data,$this->Auth->user('id'),$user_role,$this->Auth->user('created_by'));    
        $this->viewBuilder()->enableAutoLayout(false);    
        $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
        $this->viewBuilder()->setLayout('admin');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
               'filename' => 'transfered_subscriber_report' .'.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );
        $groupsTable= TableRegistry::get('Groups'); 
        if($post_data['group_id']=='all'){
            $groups_details ='all';
        }else{
            $groups_details = $groupsTable->find('all', [
                'fields' => ['group_code'],
            ])->where(['Groups.id'=>$post_data['group_id']])->first();

        }
        // echo 'groups_details<pre>';print_r($groups_details);exit;
        $this->set('branch_name', $this->Auth->user('branch_name'));
        $this->set(compact('report','post_data','groups_details'));
    }

    public function subscribersLists()
    { 
        $this->viewBuilder()->setLayout('admin');  
    } 

     function subscriberListsPdf(){
        $report =[];
        if ($this->request->is(['patch', 'post', 'put'])) {
             $user = $this->Auth->user();
            $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
            $post = $this->request->getData();   
            $report = $this->Common->getSubscribersLists($post,$this->Auth->user('id'),$user_role,$this->Auth->user('created_by'));  
            // echo '$report<pre>';print_r($report);  exit;
            $this->viewBuilder()->enableAutoLayout(false);    
            $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
            $this->viewBuilder()->setLayout('admin');
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'landscape',
                    // 'render' => 'browser',
                    'download' => true, // This can be omitted if "filename" is specified.
                   'filename' => 'subscribers_details' .'.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );

        }
        $this->set('branch_name', $this->Auth->user('branch_name'));
        $this->set(compact('report','post'));
    }

    public function dayBook()
    { 
        $this->viewBuilder()->setLayout('admin');  
    } 

     function dayBookPdf(){
         $user = $this->Auth->user();
         $user_role = isset($user['role']['name']) ? $user['role']['name'] : ''; 
        $report =[];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();   
            $report = $this->Common->getDayBookLists($post,$this->Auth->user('id'),$user_role,$this->Auth->user('created_by'));  
            // echo '$report<pre>';print_r($report);  exit;
            $this->viewBuilder()->enableAutoLayout(false);    
            $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
            $this->viewBuilder()->setLayout('admin');
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'landscape',
                    // 'render' => 'browser',
                    'download' => true, // This can be omitted if "filename" is specified.
                   'filename' => 'subscribers_details' .'.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );

        }
        $this->set('branch_name', $this->Auth->user('branch_name'));
        $this->set(compact('report','post'));
    }
}
