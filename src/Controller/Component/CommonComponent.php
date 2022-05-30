<?php
namespace App\Controller\Component;
 
use Cake\Controller\Component;
use Cake\Mailer\TransportFactory;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

class CommonComponent extends Component {
	function searchUserPermission($id, $array) {
	   foreach ($array as $key => $val) {
	       if ($val['module']['name'] === $id) {
	           return $val['permission']['permission'];
	       }
	   }
	   return null;
	}

	function randomPassword() {
	    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

    /**
    * Common send mail
    */
	function sendmail($email,$subject,$msg){
        TransportFactory::setConfig('gmail', [
          'host' => 'ssl://smtp.gmail.com',
          'port' => 25,
          'username' => 'riyajaya692@gmail.com',
          //'password' => 'etgtxblbsftaupzd',
          'password' => 'sbgindxgmawqclcz',
          'className' => 'Smtp'
        ]);
        
        try {
            Email::deliver($email, $subject, $msg, ['from' => 'votreidentifiant@gmail.com']);
            $response = 1;
        } catch (Exception $e) {
            $response = 0;
        }
        return $response;
	}

	function getMemberGroups($user_id){
		$selected_member_groups =[];
        $membergroups= TableRegistry::get('MembersGroups');
        $member_groups = $membergroups->find('all', [
            'contain' => [
                             'Groups' => function($q) use ($user_id) {
                                return $q
                                    ->select(['id','group_number'])
                                    ->where(['user_id'=>$user_id]);
                            },      
                         ],
        ])->toArray(); 
        if(!empty($member_groups)){
            foreach ($member_groups as $key => $value) { 
                $selected_member_groups[$value->group_id] = $value->group->group_number; 
            }
        }
        return $selected_member_groups;
	}

  function getGroupMember($group_id,$is_for_auction=0){
        $groupmembers =[];
        $where[] =['MembersGroups.is_transfer_user'=>0];
        if($is_for_auction==1){
            $AuctionsTable = TableRegistry::get('Auctions');
            $groupAuctionWinnerExclude = $AuctionsTable->find(
                            'list',
                            [ 'fields' =>['auction_winner_member'],
                                'conditions' => ['group_id' => $group_id]]
                        );
            $where[] = ['MembersGroups.user_id NOT IN '=>$groupAuctionWinnerExclude];
        }
        $group_members= TableRegistry::get('MembersGroups');
        $group_members = $group_members->find('all', [
            'contain' => [
                             'Groups' => function($q) use ($group_id) {
                                return $q
                                    ->select(['id','chit_amount','total_number','premium','date','late_fee','group_type','auction_date'])
                                    ->contain(['Auctions' => function($q) use ($group_id) {
                                          return $q
                                              ->select(['Auctions.group_id','Auctions.auction_date',
                                                'auction_count' => $q->func()->count('Auctions.id')
                                                ])
                                              ->where(['Auctions.group_id'=>$group_id]);
                                        }, ])
                                    ->where(['Groups.id'=>$group_id]);
                              }, 
                             'Users' => function($q) use ($group_id) {
                                return $q
                                    ->select(['id','name' => $q->func()->concat(['UPPER(SUBSTRING(Users.first_name, 1, 1)), LOWER(SUBSTRING(Users.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(middle_name, 1, 1)), LOWER(SUBSTRING(middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(last_name, 1, 1)), LOWER(SUBSTRING(last_name, 2))' => 'identifier'])])
                                    ->where(['group_id'=>$group_id,'Users.status' => 1]);
                            },    
                         ],
        ])->where($where)
        ->toArray(); 
        // echo 'group_members<pre>';print_r($group_members);exit;
        if(!empty($group_members)){ 
            $groupmembers['ticket_no'] = isset($group_members[0]['ticket_no']) ? $group_members[0]['ticket_no'] : '';
            $groupmembers['auction_count'] = isset($group_members[0]['group']['auctions'][0]['auction_count']) && ($group_members[0]['group']['auctions'][0]['auction_count'] > 0) ? ($group_members[0]['group']['auctions'][0]['auction_count']+1) : 1;
            $groupmembers['groups'] = isset($group_members[0]['group']) ? $group_members[0]['group'] : '';
         }
        $groupmembers['group_members'] = $group_members;
        return $groupmembers;
  }


  function getAllGroupMembers($user_id=0,$created_by=0){ 
      $conditions['mg.is_transfer_user']=0;
      if($user_id>0){
        $conditions['u.id']=$user_id;
      }
      if($created_by>0){
       $conditions['g.created_by']=$created_by; 
      }
      $groupMembersTable = TableRegistry::get('mg', ['table' => 'members_groups']);
      $query = $groupMembersTable->find();     
      $group_members = $query->select(['mg.ticket_no','mg.group_id','u.id',
            'name' => $query->func()->concat(['UPPER(SUBSTRING(u.first_name, 1, 1)), LOWER(SUBSTRING(u.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(middle_name, 1, 1)), LOWER(SUBSTRING(middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(last_name, 1, 1)), LOWER(SUBSTRING(last_name, 2))' => 'identifier'])
            ])
            ->join([
                'table' => 'users',
                'alias' => 'u',
                'type' => 'LEFT',
                'conditions' =>'u.id = mg.user_id',
            ]) 
            ->join([
                'table' => 'groups',
                'alias' => 'g',
                'type' => 'LEFT',
                'conditions' =>'g.id = mg.group_id',
            ])  
          ->where($conditions)
          ->toArray();   
        // echo 'group_members<pre>';print_r($group_members);exit;
          return $group_members;
  }

  // Get installment no by selecting group and member
  //   SELECT a.auction_no,max(p.id) as pid 
  //   FROM auctions a 
  //   left join payments p on a.id=p.auction_id 
  // where a.group_id = 13 
  // group by a.auction_no 
  // having pid NOT IN (SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = 2 and group_id = 13 and is_installment_complete = 1 GROUP BY group_id,user_id ASC) or pid is null
  function getInstalmentNoList($group_id,$member_id){
    $auctionTable= TableRegistry::get('Auctions'); 
    $query = $auctionTable->find();
    $instalment_nos = $query->select(['pid' => 'p.id','instalment_month'=>'MONTHNAME(Auctions.auction_date)','Auctions.net_subscription_amount',
      'due_amount' => '( CASE WHEN p.pending_amount > 0 THEN p.pending_amount ELSE Auctions.net_subscription_amount END) ',
      //'due_late_fee' => 'CalculateLateFee(Auctions.net_subscription_amount,g.late_fee,CreateDateFromDay(g.date,Auctions.auction_date,g.group_type))',
      'due_late_fee' => '( CASE WHEN (p.is_late_fee_clear <1 and p.remaining_late_fee  < 1) or (remaining_late_fee  IS NULL and is_late_fee_clear  IS NULL ) THEN 
                                        CalculateLateFee(Auctions.net_subscription_amount,g.late_fee,Auctions.auction_group_due_date)   
                                      WHEN p.is_late_fee_clear <1 and p.remaining_late_fee  > 1 THEN 
                                         p.remaining_late_fee
                                      ELSE  0.00
                                END)',
      'auction_no'=>'Auctions.auction_no','id'=>'Auctions.id',
      'plate_fee'=>'p.late_fee ',
      'due_date' => "DATE_FORMAT(Auctions.auction_group_due_date,'%m/%d/%Y')"
    ])
           ->join([
              'table' => 'payments',
              'alias' => 'p',
              'type' => 'LEFT',
              'conditions' => 'p.auction_id=Auctions.id AND
            p.id = (SELECT MAX(id) pid FROM payments WHERE user_id = '.$member_id.' and group_id = '.$group_id.'  and auction_id =Auctions.id    GROUP BY auction_id )',
          ]) 
           ->join([
              'table' => 'groups',
              'alias' => 'g',
              'type' => 'LEFT',
              'conditions' => 'g.id=Auctions.group_id',
          ])
          ->where(['Auctions.group_id'=>$group_id])
          ->group('Auctions.auction_no HAVING pid NOT IN (SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = '.$member_id.' and group_id = '.$group_id.' and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id  ASC) or pid is null')
          ->toArray(); 
    // echo '111<pre>';print_r($instalment_nos);exit;
          return $instalment_nos;
  }

   function getGroupAuctions($group_id){
        $AuctionsTable = TableRegistry::get('Auctions');
        $auctions = $AuctionsTable->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'auction_no'
                                    ])
                    ->where(['Auctions.group_id'=> $group_id,'Auctions.is_payment_done' => 0])->toArray(); 
        //echo '$auctions<pre>';print_r($auctions);exit;
        return $auctions;
  }
  
  function getAuctionDetails($auction_id){
        $auctionTable= TableRegistry::get('Auctions'); 
        $auction_details = $auctionTable->find('all', [
            'contain' => [
                             'Groups' => function($q) {
                                return $q
                                    ->select(['group_code','total_number']);
                              }, 
                             'Users' => function($q) {
                                return $q
                                    ->select(['id','auction_winner' => $q->func()->concat(['UPPER(SUBSTRING(Users.first_name, 1, 1)), LOWER(SUBSTRING(Users.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(middle_name, 1, 1)), LOWER(SUBSTRING(middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(last_name, 1, 1)), LOWER(SUBSTRING(last_name, 2))' => 'identifier'])]);
                            },    
                         ],
        ])->where(['Auctions.id'=>$auction_id])->first();
        $auction_details->auction_dt=''; 
        if(isset($auction_details->auction_date) && !empty($auction_details->auction_date)){
          $FrozenDateObj = new FrozenDate($auction_details->auction_date); 
          $auction_details->auction_dt = $FrozenDateObj->i18nFormat('MM/dd/yyyy'); 
        }
        //echo 'group_members<pre>';print_r($auction_details);exit;
        return $auction_details;      
  }
  
  function getPaymentVoucherGroupAuctions($group_id,$payment_voucher_id=0){
       $where_Conditions[]= ['Auctions.group_id'=>$group_id];
        if($payment_voucher_id>0){ 
            $where_Conditions['OR'] = [
                                    'Auctions.is_payment_done' => 0,
                                    'p.id' => $payment_voucher_id
                                ];
        }else{ 
            $where_Conditions[]= ['Auctions.is_payment_done'=>0];
        }
        //echo '$where_Conditions<pre>';print_r($where_Conditions);
        $AuctionsTable = TableRegistry::get('Auctions');
        // $auctions = $AuctionsTable->find('list', [
        //                                 'keyField' => 'id',
        //                                 'valueField' => 'auction_no'
        //                             ])
        //             ->where(['Auctions.group_id'=> $group_id,'Auctions.is_payment_done' => 0])->toArray(); 
                     
        $query = $AuctionsTable->find();     
        $aauctions = $query->select(['Auctions.id','Auctions.auction_no'])
             ->join([
                'table' => 'payment_vouchers',
                'alias' => 'p',
                'type' => 'LEFT',
                'conditions' =>'p.auction_id = Auctions.id',
            ]) 
            ->where($where_Conditions) 
            ->toArray();  
        //echo '$auctions<pre>';print_r($aauctions);  exit;
        $auctions = [];
        if(!empty($aauctions)){
            foreach($aauctions as $auction){
                $auctions[$auction->id]  = $auction->auction_no;
            }
        }    
        // echo '$auctions<pre>';print_r($auctions);exit;
        return $auctions;
  }

  function get_group_auction_date($group_id,$group_type,$group_auction_date){
    $last_dt_auction_date = ''; 
    //echo 'group_type= '.$group_type.'/$group_auction_date '.$group_auction_date."<br/>";
    if($group_id >0 && $group_type!='' &&  $group_auction_date!=''){ 
          //generate next auction date as per group type
          $last_auction_date = $this->get_last_auction_date($group_id);
          //echo '$last_auction_date  '.$last_auction_date ."<br/>";

          if($group_type == Configure::read('monthly')){  
              $group_auction_coverted_date = date('Y-m-d',strtotime(date('Y')."-".date('m')."-".$group_auction_date));
              if($last_auction_date){
                $last_acution_year = date("Y", strtotime($last_auction_date));
                $last_acution_month = date("m", strtotime($last_auction_date));

                $monthly_auction_date = date('Y-m-d',strtotime($last_acution_year."-".$last_acution_month."-".$group_auction_date)); 

                $last_dt_auction_date = date('Y-m-d', strtotime('+1 month', strtotime($monthly_auction_date)));  
              }else{
                $last_dt_auction_date = date('Y-m-d', strtotime($group_auction_coverted_date));  
              }
            } 

          if($group_type == Configure::read('fortnight')){ 

              $exploded_auction_date = !empty($group_auction_date) ? explode(',', $group_auction_date) :''; 
              if($last_auction_date==''){
                //If last auction date empty and current date is in first fortnight then create auction date
                if(date('d') >= 1 &&  date('d') <= 15 ){

                   $first_auction_date = isset($exploded_auction_date[0]) ? date('Y-m-d',strtotime(date('Y')."-".date('m')."-".$exploded_auction_date[0])) :'';
                   $last_dt_auction_date = date('Y-m-d',strtotime($first_auction_date));  
                }
                //If last auction date empty and current date is in second fortnight then create auction date
                if( date('d') >= 15 &&  date('d') <= 31){
                  $second_auction_date = isset($exploded_auction_date[1]) ? date('Y-m-d',strtotime(date('Y')."-".date('m')."-".$exploded_auction_date[1])):''; 

                 $last_dt_auction_date = date('Y-m-d',strtotime($second_auction_date)); 
               }
              }else{ 
                $last_auction_dt= date("d", strtotime($last_auction_date));
                $last_acution_year = date("Y", strtotime($last_auction_date));
                $last_acution_month = date("m", strtotime($last_auction_date)); 

                //If last auction date in first fortnight then create auction date with second group auction date
                if($last_auction_dt >= 1 && $last_auction_dt <= 15){
                    $first_fortnight_dt = strtotime($last_acution_year."-".$last_acution_month."-".$exploded_auction_date[1]); 
                    $last_dt_auction_date = date('Y-m-d',$first_fortnight_dt); 
                } 
                //If last auction date in second fortnight then create auction date with next month first group auction date
                if($last_auction_dt >= 16 && $last_auction_dt <= 31 ){
                    $second_fortnight_dt = strtotime('+1 month',strtotime($last_acution_year."-".$last_acution_month."-".$exploded_auction_date[0])); 
                    $last_dt_auction_date = date('Y-m-d',$second_fortnight_dt); 
                } 
              } 
          }

          if($group_type == Configure::read('weekly')){ 
            if($last_auction_date){ 
              $last_dt_auction_date =  date('Y-m-d', strtotime('next week '.$group_auction_date,strtotime($last_auction_date)));
            }else{   
              $weekdays=['Sunday'=>0,'Monday'=>1,'Tuesday'=>2,'Wednesday'=>3,'Thursday'=>4,'Friday'=>5,'Saturday'=>6,'Sunday'=>7]; 
              $dayofweek = date('w', strtotime(date('Y-m-d')));
              $last_dt_auction_date  = date('Y-m-d', strtotime(($weekdays[$group_auction_date] - $dayofweek).' day', strtotime(date('Y-m-d')))); 
              //$last_dt_auction_date = date('Y-m-d', strtotime(' '.$group_auction_date));
            }  
          }

          if($group_type == Configure::read('daily')){ 
            if($last_auction_date){
              $last_dt_auction_date =   date('Y-m-d', strtotime($last_auction_date. ' + 1 days'));
            }else{
              $last_dt_auction_date =  date('Y-m-d');  
            }  
          } 
          //echo 'final auction date '.$last_dt_auction_date."<br/>";exit;
    }
    if($last_dt_auction_date){
      $last_dt_auction_date = date('m/d/Y',strtotime($last_dt_auction_date));
    }
    return $last_dt_auction_date;
 }

  function get_last_auction_date($group_id){
    $last_auction_date =  ''
;    if($group_id>0){
      $auctionTable= TableRegistry::get('Auctions'); 
      $last_acution =  $auctionTable->find()
              ->select(['auction_date'])
              ->where(['group_id' => $group_id])
              ->order(['id' => 'DESC'])
              ->first();   
      if(isset($last_acution->auction_date) && !empty($last_acution->auction_date)){
          $FrozenDateObj = new FrozenDate($last_acution->auction_date); 
          $last_auction_date = $FrozenDateObj->i18nFormat('yyyy-MM-dd'); 
      }
    }
    return $last_auction_date;        
  }

  function getReceiptStatement($post,$user_id,$user_role,$created_by){
    $payments =[];
    if(isset($post['start']) && isset($post['end']) && isset($post['search_by'])){
       $post['start']= strtotime($post['start']) > 0 ? date('Y-m-d',strtotime($post['start'])) : ''; 
       $post['end']= strtotime($post['end']) > 0 ? date('Y-m-d',strtotime($post['end'])) : '';
        //echo '$post<pre>';print_r($post); 
       $where_Conditions = [];
       if($post['search_by'] == 'group_by' ){
          $where_Conditions[]= ['g.id'=>$post['group_id']];
       }
       if($post['search_by'] == 'member_by'){
          $where_Conditions[]= ['u.id'=>$post['user_id']];
       }
       $role_wise_conditions = [];
       if($user_role == Configure::read('ROLE_ADMIN')){
            $role_wise_conditions['p.created_by'] =$user_id;
        }
        if($user_role == Configure::read('ROLE_MEMBER')){
            $role_wise_conditions['p.user_id'] =$user_id;
            $role_wise_conditions['p.created_by'] =$created_by;
        }
        if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
            $role_wise_conditions['p.created_by'] =$created_by;
        } 

        //echo '$where_Conditions<pre>';print_r($where_Conditions);//exit;
        $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
        $query = $PaymentsTable->find();     
        $payments = $query->select([ 'p.receipt_no','date'=>"DATE_FORMAT(p.date,'%m/%d/%Y')",'g.group_code',
            'member'=>"concat(u.first_name,' ', u.middle_name,' ',u.last_name)",
            'p.subscriber_ticket_no',
            'p.instalment_no',
            'p.instalment_month',
            'due_date'=>"DATE_FORMAT(p.due_date,'%m/%d/%Y')",
            'p.subscription_amount','p.late_fee','p.total_amount',
            'receivedby'=>"(
            CASE 
                WHEN p.received_by =1 THEN 'Cash'
                WHEN p.received_by =2 THEN 'Cheque'
                WHEN p.received_by =3 THEN 'Direct Debit' 
                ELSE '--'
            END)",
            'p.remark',
            'ug.branch_name',
          ])
             ->join([
                'table' => 'groups',
                'alias' => 'g',
                'type' => 'LEFT',
                'conditions' =>'p.group_id = g.id',
            ]) 
            ->join([
                'table' => 'users',
                'alias' => 'ug',
                'type' => 'LEFT',
                'conditions' =>'g.created_by = ug.id',
           ]) 
           ->join([
                'table' => 'users',
                'alias' => 'u',
                'type' => 'LEFT',
                'conditions' =>'p.user_id = u.id',
            ])  
            ->where(['p.date >='=> $post['start'],'p.date <='=> $post['end']])
            ->where($role_wise_conditions)
            ->where($where_Conditions)
            ->toArray();  
    }
    // echo '$payments<pre>';print_r($payments);  exit;
    return $payments;
  }

  function getInstalmentDetails($post,$user_id,$user_role,$created_by){
    $report['payments'] =[];
    $report['all_months_due_amount'] = 0;

    if(isset($post['start']) && isset($post['end']) && isset($post['user_id'])){
       $post['start']= strtotime($post['start']) > 0 ? date('Y-m-d',strtotime($post['start'])) : ''; 
       $post['end']= strtotime($post['end']) > 0 ? date('Y-m-d',strtotime($post['end'])) : '';
        $where_Conditions[]= ['p.user_id'=>$post['user_id']];
        // echo '$post<pre>';print_r($post);

        $role_wise_conditions = [];
        if($user_role == Configure::read('ROLE_ADMIN')){
            $role_wise_conditions['p.created_by'] =$user_id;
        }
        if($user_role == Configure::read('ROLE_MEMBER')){
            $role_wise_conditions['p.user_id'] =$user_id;
            $role_wise_conditions['p.created_by'] =$created_by;
        }
        if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
            $role_wise_conditions['p.created_by'] =$created_by;
        } 

        $report['all_months_due_amount'] = $this->getAllMonthsDueAmount($post['user_id']);
        // echo '$all_months_due_amount '.$report['all_months_due_amount'];

        $report['total_fully_paid_interest'] = $this->getTotalFullyPaidInterest($post['user_id']);

        $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
        
        
        $query = $PaymentsTable->find();     
        $report['payments'] = $query->select([ 'p.receipt_no','date'=>"DATE_FORMAT(p.date,'%m/%d/%Y')",'g.group_code',
            'p.subscriber_ticket_no',
            'p.instalment_no',
            'p.instalment_month',
            'due_date'=>"DATE_FORMAT(p.due_date,'%m/%d/%Y')",
            'p.subscription_amount','p.late_fee','p.total_amount',
            'receivedby'=>"(
            CASE 
                WHEN p.received_by =1 THEN 'Cash'
                WHEN p.received_by =2 THEN 'Cheque'
                WHEN p.received_by =3 THEN 'Direct Debit' 
                ELSE '--'
            END)",
            'p.remark', 
            ])
             ->join([
                'table' => 'groups',
                'alias' => 'g',
                'type' => 'LEFT',
                'conditions' =>'p.group_id = g.id',
            ])  
            ->where(['p.date >='=> $post['start'],'p.date <='=> $post['end']])
            ->where($role_wise_conditions)
            ->where($where_Conditions)
            ->toArray();  
    }
    // echo '$report<pre>';print_r($report);  exit;
    return $report;
  }

  function getTotalFullyPaidInterest($user_id){
      $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
      $query = $PaymentsTable->find();     
      $payments = $query->select(['total_fully_paid_interest'=>"count(p.id)"])
          ->where(['p.user_id'=>$user_id,'p.is_installment_complete'=>1])->first() ;
          // ->first();  
    // echo '$total_amount <pre>';print_r($payments);
       //exit;
      return $payments->total_fully_paid_interest;    
  }

  function getAllMonthsDueAmount($payment_user_id,$payment_group_id=0){
        if($payment_user_id < 1 ){ 
           return 0;
        }

        $conn = ConnectionManager::get('default');
        $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
        $aColumns = [ 
            'Auctions.auction_no',
            "MONTHNAME(Auctions.auction_date) as instalment_month",
            'Auctions.net_subscription_amount',
            " @due_amount :=( CASE WHEN p.remaining_subscription_amount > 0 THEN p.remaining_subscription_amount ELSE Auctions.net_subscription_amount END) as due_amount",
            " @due_late_fee := ( CASE WHEN (p.is_late_fee_clear <1 and p.remaining_late_fee  < 1) or (remaining_late_fee  IS NULL and is_late_fee_clear  IS NULL ) THEN 
                                        CalculateLateFee(Auctions.net_subscription_amount,g.late_fee,Auctions.auction_group_due_date)   
                                      WHEN p.is_late_fee_clear <1 and p.remaining_late_fee  > 1 THEN 
                                         p.remaining_late_fee
                                      ELSE  0.00
                                END)
            as due_late_fee" ,
            
            "round((@due_amount + @due_late_fee),2) as total_amount"
        ]; 
        if($payment_group_id > 0){
            $sQuery = " 
              SELECT SUM(total_amount) total_amount from 
              (
                  SELECT p.id as pid, ".str_replace(' , ', ' ', implode(', ', $aColumns))." 
                      FROM auctions Auctions
                      LEFT JOIN payments p ON p.auction_id=Auctions.id AND p.id = (
                      SELECT MAX(id) pid FROM payments WHERE user_id = $payment_user_id and group_id = $payment_group_id and auction_id =Auctions.id GROUP BY auction_id 
                    )   
          
                      LEFT JOIN groups g on Auctions.group_id = g.id WHERE Auctions.group_id = $payment_group_id 
                      GROUP BY Auctions.auction_no HAVING pid NOT IN (
                              SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = $payment_user_id and group_id = $payment_group_id and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id ASC
                            ) or pid is null ORDER BY Auctions.auction_no asc
              
              ) t
          ";
        }else{
          $sQuery = " 
              SELECT SUM(total_amount) total_amount from 
              (
                  SELECT p.id as pid, ".str_replace(' , ', ' ', implode(', ', $aColumns))." 
                      FROM auctions Auctions
                      LEFT JOIN payments p ON p.auction_id=Auctions.id AND p.id = (
                        SELECT MAX(id) pid FROM payments WHERE user_id = $payment_user_id and auction_id =Auctions.id GROUP BY auction_id 
                      )   
                      LEFT JOIN groups g on Auctions.group_id = g.id 

                      WHERE Auctions.group_id in (SELECT group_id  FROM members_groups WHERE user_id = $payment_user_id)

                      GROUP BY Auctions.auction_no, Auctions.group_id

                      HAVING pid NOT IN (
                              SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = $payment_user_id
                              and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id ASC
                            ) or pid is null ORDER BY Auctions.auction_no asc
              
              ) t
          ";
        }
        
        // echo $sQuery."<br/>";

        $rResultTotal = $conn->execute($sQuery);
        $aResultTotal = $rResultTotal ->fetch('assoc');
        // echo '$aResultTotal<pre>';print_r($aResultTotal);exit;
        return $aResultTotal['total_amount'];
    }

    public function getSubscribersDetails($post,$user_id,$user_role,$created_by)
    {
        $result=[];
        if(isset($post['group_id']) && isset($user_id)){
            $role_wise_conditions = [];
            if($user_role == Configure::read('ROLE_ADMIN')){
                $role_wise_conditions['g.created_by'] =$user_id;
            }
            if($user_role == Configure::read('ROLE_MEMBER')){
                $role_wise_conditions['g.user_id'] =$user_id;
                $role_wise_conditions['g.created_by'] =$created_by;
            }
            if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
                $role_wise_conditions['g.created_by'] =$created_by;
            } 

            $payment= TableRegistry::get('Payments');
            $subquery = $payment->find();
            $subquery->select([
                'p_id' => 'Payments.id', 
                'p_group_id' => 'Payments.group_id', 
                'p_user_id' => 'Payments.user_id', 
                'paid_sub_amt' => "SUM(Payments.subscription_amount)", 
                'paid_instalments' => "SUM(if(is_installment_complete = '1', 1, 0))", 
            ]) 
            ->group(['group_id']);

            $membersGroupsTable = TableRegistry::get('mg', ['table' => 'members_groups']);
            $query = $membersGroupsTable->find();
            $result = $query->select([
                            'g.group_code','g.chit_amount','g.total_number','g.premium',
                            'mg.temp_customer_id','mg.ticket_no',
                            'member'=>"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name))",
                            'u.customer_id','a.agent_code',
                            'p.paid_sub_amt','p.paid_instalments',
                            'is_transfer_member_status'=>"( CASE WHEN (mg.is_transfer_user = 1 ) THEN 
                                        'Transfered'
                                      ELSE  '-'
                                END)",
                            'ug.branch_name',
                          ])
                ->join([
                    'table' => 'groups',
                    'alias' => 'g',
                    'type' => 'LEFT',
                    'conditions' =>'mg.group_id = g.id',
                ]) 
               ->join([
                    'table' => 'users',
                    'alias' => 'u',
                    'type' => 'LEFT',
                    'conditions' =>'mg.user_id = u.id',
                ])  
                ->join([
                    'table' => 'agents',
                    'alias' => 'a',
                    'type' => 'LEFT',
                    'conditions' =>'u.agent_id = a.id',
                ])  
               ->join([
                    'table' => 'users',
                    'alias' => 'ug',
                    'type' => 'LEFT',
                    'conditions' =>'g.created_by = ug.id',
                ]) 
                ->join([
                  'table' => '('.$subquery.')',
                  'alias' => 'p',
                  'type' => 'LEFT',
                  'conditions' => 'p.p_group_id = g.id and p.p_user_id=u.id ',
               ]) 
               ->where(['g.id'=>$post['group_id']])
               ->where($role_wise_conditions)
               ->toArray();
               // echo '$result<pre>';print_r($result);exit;
        }
        return $result;
    }    

    public function getAuctionsDetails($post,$user_id,$user_role,$created_by)
    {
      $post['start']= strtotime($post['start']) > 0 ? date('Y-m-d',strtotime($post['start'])) : ''; 
      $post['end']= strtotime($post['end']) > 0 ? date('Y-m-d',strtotime($post['end'])) : '';  
      $role_wise_conditions = [];
        if($user_role == Configure::read('ROLE_ADMIN')){
            $role_wise_conditions['a.created_by'] =$user_id;
        }
        if($user_role == Configure::read('ROLE_MEMBER')){
            $role_wise_conditions['a.created_by'] =$created_by;
        }
        if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
            $role_wise_conditions['a.created_by'] =$created_by;
        } 

      $AuctionsTable = TableRegistry::get('a', ['table' => 'auctions']);
      $query = $AuctionsTable->find();     
      $auctions = $query->select(['a.auction_no','a.auction_date','a.auction_highest_percent','a.ticket_no','a.priced_amount','a.total_subscriber_dividend','a.subscriber_dividend',
           'member' =>"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name))",
            ]) 
           ->join([
                'table' => 'users',
                'alias' => 'u',
                'type' => 'LEFT',
                'conditions' =>'a.auction_winner_member = u.id',
            ])  
          ->where(['a.auction_date >='=> $post['start'],'a.auction_date <='=> $post['end'],'a.group_id'=>$post['group_id']]) 
          ->where($role_wise_conditions)
          ->toArray();  
           // echo '$auctions<pre>';print_r($auctions);  exit;
      return $auctions;    
    }

     function getGroupsDetails($post, $user_id,$user_role,$created_by){
            $role_wise_conditions = [];
            if($user_role == Configure::read('ROLE_ADMIN')){
                $role_wise_conditions['g.created_by'] =$user_id;
            }
            if($user_role == Configure::read('ROLE_MEMBER')){
                $role_wise_conditions['g.user_id'] =$user_id;
                $role_wise_conditions['g.created_by'] =$created_by;
            }
            if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
                $role_wise_conditions['g.created_by'] =$created_by;
            } 
          $GroupsTable = TableRegistry::get('g', ['table' => 'groups']);
          $query = $GroupsTable->find();     
          $groups = $query->select(['g.group_code','g.chit_amount','g.total_number','g.premium',
                    'ug.branch_name',
                    'ug.address',
                    'ug.city',
                    'ug.state',
                    'a.agent_code',
                ])
                ->join([
                    'table' => 'users',
                    'alias' => 'ug',
                    'type' => 'LEFT',
                    'conditions' =>'g.created_by = ug.id',
                ]) 
                ->join([
                    'table' => 'agents',
                    'alias' => 'a',
                    'type' => 'LEFT',
                    'conditions' =>'a.id = ug.agent_id',
                ]) 
              ->where(['g.id'=>$post['group_id']]) 
              ->where($role_wise_conditions)
              ->first();  
          return $groups;    
      }

      function getUserGroupDetails($post, $user_id,$user_role,$created_by){
           $role_wise_conditions = [];
            if($user_role == Configure::read('ROLE_ADMIN')){
                $role_wise_conditions['g.created_by'] =$user_id;
            }
            if($user_role == Configure::read('ROLE_MEMBER')){ 
                $role_wise_conditions['g.created_by'] =$created_by;
            }
            if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
                $role_wise_conditions['g.created_by'] =$created_by;
            } 

          $UsersTable = TableRegistry::get('u', ['table' => 'users']);
          $query = $UsersTable->find();     
          $groups = $query->select(['g.group_code','g.chit_amount','g.total_number','g.premium',
                    'ug.branch_name',
                    'ug.address',
                    'ug.city',
                    'ug.state',
                    'u.area_code',
                    'member' =>"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name))",
                    'address_u' =>"CONCAT_WS(', ',IF(u.address = '', NULL, u.address),IF(u.city = '', NULL, u.city),IF(u.state = '', NULL, u.state))",
                    'u.pin_code',
                    'a.agent_code',
                ])
                ->join([
                    'table' => 'members_groups',
                    'alias' => 'mg',
                    'type' => 'LEFT',
                    'conditions' =>'u.id = mg.user_id',
                ]) 
                ->join([
                    'table' => 'groups',
                    'alias' => 'g',
                    'type' => 'LEFT',
                    'conditions' =>'g.id = mg.group_id',
                ]) 
                ->join([
                    'table' => 'users',
                    'alias' => 'ug',
                    'type' => 'LEFT',
                    'conditions' =>'g.created_by = ug.id',
                ]) 
                 ->join([
                    'table' => 'agents',
                    'alias' => 'a',
                    'type' => 'LEFT',
                    'conditions' =>'a.id = ug.agent_id',
                ]) 
              ->where(['u.id'=>$post['user_id']]) 
              ->where($role_wise_conditions)
              ->first();  
          return $groups;    
      }

      function getGroupList($user_id)
      {
          $GroupsTable = TableRegistry::get('g', ['table' => 'groups']);
          $query = $GroupsTable->find();     
          $groups = $query->select(['g.group_code','g.chit_amount','g.total_number',
                   'g.gov_reg_no','g.date','g.no_of_months','g.bank_deposite_date',
                   'g.deposite_maturity_date','g.group_type',
                   'group_status'=>"(
                        CASE 
                            WHEN g.is_all_auction_completed =0 THEN 'Active'
                            WHEN g.is_all_auction_completed =1 THEN 'Close'
                            ELSE '--'
                        END)"
                ]) 
              ->where(['g.created_by'=>$user_id]) 
              ->toArray();  
          return $groups;   
      }

      function getVacantMemberDetails($user_id,$group_id=0,$user_role,$created_by){
        $role_wise_conditions = [];
        if($user_role == Configure::read('ROLE_ADMIN')){
            $role_wise_conditions['g.created_by'] =$user_id;
        }
        if($user_role == Configure::read('ROLE_MEMBER')){
            $role_wise_conditions['g.user_id'] =$user_id;
            $role_wise_conditions['g.created_by'] =$created_by;
        }
        if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
            $role_wise_conditions['g.created_by'] =$created_by;
        } 

        $MembersGroupsTable = TableRegistry::get('mg', ['table' => 'members_groups']);
        $query = $MembersGroupsTable->find();  
        $AuctionsTable = TableRegistry::get('Auctions');
        $include = $AuctionsTable->find(
                        'list',
                        [ 'fields' =>['group_id'],
                            'conditions' => ['auction_group_due_date < ' => 'CURRENT_DATE()'],
                            'group' =>['group_id'],
                            'order'=> ['group_id'=>'ASC']]
                    );
        $where_Conditions = [];
        if($group_id>0){
            $where_Conditions = ['mg.group_id'=>$group_id];
        }

        $groups = $query->select([
                    'gr_code_ticket'=>"concat(g.group_code,'-',mg.ticket_no)",
                    'g.chit_amount','g.no_of_months','g.premium','mg.ticket_no'
                    ,'member' =>"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name))",
                    'no_of_installments' =>"(SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id)",
                    'total_amt_payable'=>"(SELECT SUM(net_subscription_amount) FROM auctions WHERE group_id = mg.group_id)",
                    'total_dividend'=>"(SELECT SUM(subscriber_dividend) FROM auctions WHERE group_id = mg.group_id)",
                    'auction_winner'=>"(SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id AND auction_winner_member =mg.user_id)"
                    ,'mg.group_id','mg.user_id'
                    ,'pi'=>"Pending_Installments(mg.group_id,mg.user_id)"
                ])
                ->join([
                    'table' => 'groups',
                    'alias' => 'g',
                    // 'type' => 'JOIN',
                    'conditions' =>'g.id = mg.group_id',
                ]) 
                ->join([
                    'table' => 'users',
                    'alias' => 'u',
                    // 'type' => 'JOIN',
                    'conditions' =>'mg.user_id = u.id',
                ]) 
              ->where($role_wise_conditions)  
               ->where(['mg.group_id IN '=>$include])  
              ->where($where_Conditions)
              // ->where(['mg.group_id IN '=>" (SELECT group_id FROM auctions WHERE auction_group_due_date < CURRENT_DATE() group by group_id ORDER BY group_id ASC)"])
              ->having(['pi >='=>3,'auction_winner'=>0])
              ->order(['mg.group_id' => 'ASC','mg.user_id'=>'ASC'])->toArray();  
          // echo '$groups <pre>';print_r($groups);exit;    
          return $groups;    
      }

      function getRoleWiseConditions($user_id,$user_role,$created_by,$tablenm){
            $role_wise_conditions = [];
            if($user_role == Configure::read('ROLE_ADMIN')){
                $role_wise_conditions[$tablenm.'.created_by'] =$user_id;
            }
            if($user_role == Configure::read('ROLE_MEMBER')){
                $role_wise_conditions[$tablenm.'.user_id'] =$user_id;
                $role_wise_conditions[$tablenm.'.created_by'] =$created_by;
            }
            if($user_role == Configure::read('ROLE_USER') || $user_role == Configure::read('ROLE_AGENT') || $user_role == Configure::read('ROLE_BRANCH_HEAD') || $user_role == Configure::read('ROLE_ASSISTANT_HEAD')){
                $role_wise_conditions[$tablenm.'.created_by'] =$created_by;
            } 
              // echo '$pv <pre>';print_r($role_wise_conditions);exit;
            return $role_wise_conditions;
      }
      function getFormanCommissionDetailsPdf($post,$user_id,$user_role,$created_by){
        $role_wise_conditions=$this->getRoleWiseConditions($user_id,$user_role,$created_by,'g');
        $post['start']= strtotime($post['start']) > 0 ? date('Y-m-d',strtotime($post['start'])) : '';
        $post['end']= strtotime($post['end']) > 0 ? date('Y-m-d',strtotime($post['end'])) : ''; 

        $PaymentVouchersTable = TableRegistry::get('pv', ['table' => 'payment_vouchers']);
        $query = $PaymentVouchersTable->find();   
        $payment_vouchers = $query->select([ 'pv.date','g.group_code','pv.auction_date','a.auction_no','member' =>"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name))",
                    'g.chit_amount','pv.foreman_commission','pv.gst','a.priced_amount',
                    'pv.cheque_dd_no','pv.total','a.ticket_no','g.gov_reg_no'
                ])
                ->join([
                    'table' => 'groups',
                    'alias' => 'g', 
                    'conditions' =>'g.id = pv.group_id',
                ]) 
                ->join([
                    'table' => 'users',
                    'alias' => 'u', 
                    'conditions' =>'pv.user_id = u.id',
                ]) 
                ->join([
                    'table' => 'auctions',
                    'alias' => 'a', 
                    'conditions' =>'pv.auction_id = a.id',
                ]) 
              ->where(['g.id'=>$post['group_id']])   
              ->where($role_wise_conditions)
              ->where(['pv.date >='=> $post['start'],'pv.date <='=> $post['end']]) 
              ->order(['pv.group_id' => 'ASC']);//->toArray();  
          // echo '$pv <pre>';print_r($payment_vouchers);exit;    
          return $payment_vouchers; 
      }

      function getAuctionGroupsDetails($user_id)
      {
        $AuctionsTable = TableRegistry::get('a', ['table' => 'auctions']);
        $query = $AuctionsTable->find();  
        $groups = $query->select([ 
                    'gr_code_ticket'=>"concat(g.group_code,'-',mg.ticket_no)",
                    'g.chit_amount','g.no_of_months','g.premium','mg.ticket_no'
                    ,'member' =>"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name))",
                    'no_of_installments' =>"(SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id)",
                    'total_amt_payable'=>"(SELECT SUM(net_subscription_amount) FROM auctions WHERE group_id = mg.group_id)",
                    'total_dividend'=>"(SELECT SUM(subscriber_dividend) FROM auctions WHERE group_id = mg.group_id)",
                    'auction_winner'=>"(SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id AND auction_winner_member =mg.user_id)"
                    ,'mg.group_id','mg.user_id' 
                ])
                ->join([
                    'table' => 'groups',
                    'alias' => 'g',
                    // 'type' => 'JOIN',
                    'conditions' =>'g.id = mg.group_id',
                ]) 
              ->where(['g.created_by'=>$user_id]) 
              ->order(['g.group_id' => 'ASC'])->toArray();  
          // echo '$groups <pre>';print_r($groups);exit;    
          return $groups;  
      }

      function getTransferGroupUser($user_ids,$group_id){
        if(!($user_ids)  or !($group_id)){
            return false;
        }
        $PaymentsTable = TableRegistry::get('Payments');
        $exclude = $PaymentsTable->find(
                        'list',
                        [ 'fields' =>['user_id'],
                            'conditions' => ['group_id' => $group_id]]
                    );
        $AuctionsTable = TableRegistry::get('Auctions');
        $groupAuctionWinnerExclude = $AuctionsTable->find(
                        'list',
                        [ 'fields' =>['auction_winner_member'],
                            'conditions' => ['group_id' => $group_id]]
                    );
        $UsersTable= TableRegistry::get('u', ['table' => 'users']);
        $query = $UsersTable->find('all'); 
        $where_Conditions['OR'] = [
                                    'mg.is_transfer_user'=>0,
                                    'mg.is_transfer_user IS NULL'
                                ];
        $users =  $query->select([ 'u.id','member' =>"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name))" 
                    ])
                    ->join([
                    'table' => 'members_groups', 
                        'alias' => 'mg', 
                        'type' => 'LEFT',
                        'conditions' =>'mg.user_id = u.id',
                    ]) 
                    ->join([
                    'table' => 'roles', 
                        'conditions' =>'roles.id = u.role_id',
                    ]) 
                ->where(['u.id NOT IN '=>$exclude,'u.id NOT IN '=> $groupAuctionWinnerExclude])
                ->where($where_Conditions)
                ->where(['u.status ' => 1,'u.id NOT IN '=>$user_ids,'roles.name' => Configure::read('ROLE_MEMBER')])
                ->group('u.id')->toArray();
                // echo 'users<pre>';print_r($users);exit;
        return $users;
      }

      function getTransferedSubscriberDetails($post,$user_id,$user_role,$created_by){

        $MembersGroupsTable = TableRegistry::get('mg', ['table' => 'members_groups']);
        $query = $MembersGroupsTable->find();   
        $role_wise_conditions=$this->getRoleWiseConditions($user_id,$user_role,$created_by,'g');
        $where_Conditions = ['mg.is_transfer_user'=>1];

        if($post['group_id'] != 'all'){
            $where_Conditions = ['g.id'=>$post['group_id']];
        } 

        $transferedMembers = $query->select([ 
            'g.group_code','mg.ticket_no'
            ,'old_subscriber' =>"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name))",
            'terminate_date' => "date_format(mg.created_date, '%m/%d/%Y')",
            'g.gov_reg_no',
            'new_subscriber' =>"CONCAT_WS(' ',IF(nu.first_name = '', NULL, nu.first_name),IF(nu.middle_name = '', NULL, nu.middle_name),IF(nu.last_name = '', NULL, nu.last_name))",
            'address_new_member'=>'nu.address'
                ])
                ->join([
                    'table' => 'groups',
                    'alias' => 'g', 
                    'conditions' =>'g.id = mg.group_id',
                ]) 
                ->join([
                    'table' => 'users',
                    'alias' => 'u', 
                    'conditions' =>'mg.user_id = u.id',
                ]) 
                 ->join([
                    'table' => 'users',
                    'alias' => 'nu', 
                    'conditions' =>'mg.new_user_id = nu.id',
                ]) 
              ->where($where_Conditions)  
              ->where($role_wise_conditions)
              ->order(['mg.group_id' => 'ASC'])->toArray();  
          // echo '$pv <pre>';print_r($transferedMembers);exit;    
          return $transferedMembers; 
      }

      function getAmountByReceivedBy($received_by,$user_id,$user_id_param =0){
        $conn = ConnectionManager::get('default');
        $sQuery = "call CalculateMoneyNotes($received_by,$user_id,$user_id_param);";
        $rResultTotal = $conn->execute($sQuery);
        $aResultTotal = $rResultTotal ->fetchAll('assoc');
        return $aResultTotal; 
      }

      function getAllMonthsCurrentYearPayments($user_id){

        $MonthsTable = TableRegistry::get('m', ['table' => 'months']);
        $query = $MonthsTable->find();   
        
        $conditions = array(
               'AND' => array( 
                   array(
                     'OR'=>array(
                        ['YEAR(p.due_date)'=> date("Y")],
                        ['YEAR(p.due_date) is '=> NULL]
                     )
                   ),
                   array(
                     'OR'=>array(
                        ['p.created_by'=>$user_id],
                        ['p.created_by is '=> NULL]
                     )
                  ),
               )
            );

        $data = $query->select([ 
                    //'m.month',
                   // 'month' =>"DATE_FORMAT(due_date, '%M')",
                    'total_amount' => "IFNULL(SUM(total_amount), 0 )"
                ]) 
              ->join([
                    'table' => 'payments',
                    'alias' => 'p', 
                    'type' => 'LEFT',
                    'conditions' =>"m.month=DATE_FORMAT(p.due_date, '%M')",
                ])  
              ->where($conditions)  
              ->group(["m.month"])
              ->order(['m.id' => 'ASC'])->toArray();   
          $result = json_encode(array_column($data, 'total_amount'));

          // echo '$result <pre>';print_r(  $result);exit;   

          return $result; 
      }

      function getAllSuccessfullTransaction($user_id,$user_id_param=0){
          $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
          $query = $PaymentsTable->find();     

          if($user_id == -1){
            $conditions['p.created_by > '] =0;
          }else{
            $conditions['p.created_by'] =$user_id;
          }
          $conditions['p.is_installment_complete'] =1;
          if($user_id_param>0){
            $conditions['p.user_id'] = $user_id_param;
          }
          // echo '<pre>';print_r($conditions);exit;
          $payments = $query->select(['total_fully_paid_interest'=>"count(p.id)"])
              ->where($conditions) 
              ->first();  
          return $payments->total_fully_paid_interest;    
      }

      function getGroupCount($user_id,$user_id_param=0){
         $GroupsTable = TableRegistry::get('g', ['table' => 'groups']);
          $query = $GroupsTable->find();     
          if($user_id == -1){
            $conditions['g.created_by > '] = 0;
          }else{
             $conditions['g.created_by'] = $user_id;
          }
          if($user_id_param>0){
            $conditions['mg.user_id'] = $user_id_param;
          $groups = $query->select(['total_groups'=>"count(g.id)"])
              ->join([
                    'table' => 'members_groups',
                    'alias' => 'mg', 
                    'type' => 'LEFT',
                    'conditions' =>"g.id=mg.group_id",])
              ->where($conditions) 
              ->first(); 
              // echo '$groups<pre>';print_r($groups);exit;
          }else{
            $groups = $query->select(['total_groups'=>"count(g.id)"])
              ->where($conditions) 
              ->first();  

          }
          return $groups->total_groups;
      }

       function getMemberCount($user_id,$user_id_param=0){
          $UsersTable = TableRegistry::get('u', ['table' => 'users']);
          $query = $UsersTable->find();     
          $conditions['u.status']=1;
          $conditions['r.name']=Configure::read('ROLE_MEMBER');
          if($user_id == -1){
            $conditions['u.created_by > ']=0;
          }else{
            $conditions['u.created_by']=$user_id;
          }
           if($user_id_param>0){
            $conditions['mg.user_id']=$user_id_param;
            $MembersGroupTable = TableRegistry::get('mg', ['table' => 'members_groups']);
            $query = $MembersGroupTable->find();
            $subquery = $query->select(['mg.group_id'])
                     ->join([
                        'table' => 'users',
                        'alias' => 'u', 
                        'type' => 'LEFT',
                        'conditions' =>"u.id=mg.user_id",
                    ]) 
                     ->join([
                        'table' => 'roles',
                        'alias' => 'r', 
                        'type' => 'LEFT',
                        'conditions' =>"r.id=u.role_id",
                    ]) 
                  ->where($conditions) 
                 ->toArray();  
                $member_group_ids = array_column($subquery, 'group_id');

                  //echo '<pre>';print_r( $member_group_ids);//exit;
              
              $MembersGroupsTable = TableRegistry::get('mgs', ['table' => 'members_groups']);
              $query = $MembersGroupsTable->find();
              $members = $query->select(['total_members'=>"count(mgs.id)"])
                         ->where(['group_id IN '=>$member_group_ids])->first();
                          // echo 'members<pre>';print_r($members);exit;
            
           }else{
              $members = $query->select(['total_members'=>"count(u.id)"])
                     ->join([
                        'table' => 'roles',
                        'alias' => 'r', 
                        'type' => 'LEFT',
                        'conditions' =>"r.id=u.role_id",
                    ]) 
                  ->where($conditions) 
                  ->first();  
           }
          return $members->total_members;
      }

       function getAuctionsCount($user_id,$user_id_param=0){
          $AuctionsTable = TableRegistry::get('a', ['table' => 'auctions']);
          $query = $AuctionsTable->find();     
          if($user_id == -1){
            $conditions = ['a.created_by > 0'=>$user_id];
          }else{
             $conditions = ['a.created_by'=>$user_id];
          }
           if($user_id_param>0){
            $MembersGroupTable = TableRegistry::get('mg', ['table' => 'members_groups']);
            $query2 = $MembersGroupTable->find();
            $subquery = $query2->select(['mg.group_id']) 
                  ->where(['mg.user_id'=>$user_id_param,'mg.created_by'=>$user_id]) 
                 ->toArray();  
                $member_group_ids = array_column($subquery, 'group_id');

            $auctions = $query->select(['total_auctions'=>"count(a.id)"]) 
              ->where(['a.group_id IN '=>$member_group_ids]) 
              ->first();  
          }else{
          $auctions = $query->select(['total_auctions'=>"count(a.id)"]) 
              ->where($conditions) 
              ->first();  

          }
          return $auctions->total_auctions;
      }
      function getPaymentsCount($user_id,$user_id_param=0){
          $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
          $query = $PaymentsTable->find();  
          if($user_id == -1){
            $conditions = ['p.created_by > 0'=>$user_id];
          }else{
             $conditions = ['p.created_by'=>$user_id];
          }   
           if($user_id_param>0){
            $conditions['p.user_id'] = $user_id_param;
          }
          $payments = $query->select(['total_payments'=>"count(p.id)"]) 
              ->where($conditions) 
              ->first();  
          return $payments->total_payments;
      }

    /**
    * this function ussed for image and user documents upload
    * fun used for profile inf and member add edit
    */
    public function userDocUpload($db_upload_field, $post, $path = '', $id=0,$table_name='agents'){
        $name = $post->getClientFilename();
        $filename = '';
        if($name){
            $name = preg_replace('/[(){}]/', '', $name);
            $name = str_replace(' ', '', $name);

            $sffledStr= str_shuffle('encrypt');
            $uniqueString = md5(time().$sffledStr);
             
            //get existing file name
            $AgentsTable = TableRegistry::get('a', ['table' => $table_name]);
            $query = $AgentsTable->find();     
            $agents = $query->select("a.".$db_upload_field) 
                  ->where(['a.id'=>$id]) 
                  ->first();   

            //create path
            if(empty($path)){
                $path = WWW_ROOT.DS.'users_docs'.DS.$db_upload_field;
            }
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            //get exsiting doc from db 
            $existing_doc = $agents->$db_upload_field;
            if (($existing_doc) && file_exists($path.DS.$existing_doc)){
                unlink( $path.DS.$existing_doc);
            }
            
            $filename = $id.'_'.$uniqueString.'_'.$name;
            $targetPath = $path.DS.$filename;
            $post->moveTo($targetPath);
        }
        return $filename;
    }

    function getSubscribersLists($post, $user_id,$user_role,$created_by){
          $role_wise_conditions=$this->getRoleWiseConditions($user_id,$user_role,$created_by,'u');
          $UsersTable = TableRegistry::get('u', ['table' => 'users']);
          $query = $UsersTable->find();     
          $users = $query->select(['mg.id','mg.old_user_id','name' => $query->func()->concat(['UPPER(SUBSTRING(u.first_name, 1, 1)), LOWER(SUBSTRING(u.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(u.middle_name, 1, 1)), LOWER(SUBSTRING(u.middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(u.last_name, 1, 1)), LOWER(SUBSTRING(u.last_name, 2))' => 'identifier', ' , ','u.address'=> 'identifier']), 
                     'date' => "DATE_FORMAT(g.created_date,'%m/%d/%Y')",
                     'mg.ticket_no',
                     'g.chit_amount',
                   'trans_name' => $query->func()->concat(['UPPER(SUBSTRING(trans_u.first_name, 1, 1)), LOWER(SUBSTRING(trans_u.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(trans_u.middle_name, 1, 1)), LOWER(SUBSTRING(trans_u.middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(u.last_name, 1, 1)), LOWER(SUBSTRING(trans_u.last_name, 2))' => 'identifier', ', ','trans_u.address'=>'identifier']),
                        'trans_date' => "DATE_FORMAT(trans_g.created_date,'%m/%d/%Y')",
                         'trans_g.chit_amount',
                         'trans_mg.ticket_no',
                         'trans_mg.removal_resaon',
                     // 'branch_name' => $q->func()->concat(['UPPER(SUBSTRING(branch.first_name, 1, 1)), LOWER(SUBSTRING(branch.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(branch.middle_name, 1, 1)), LOWER(SUBSTRING(branch.middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(branch.last_name, 1, 1)), LOWER(SUBSTRING(branch.last_name, 2))' => 'identifier']),
                     // 'branch.address',
                     // 'branch_date' => "DATE_FORMAT(branch.created_date,'%m/%d/%Y')",
                     'mg.is_transfer_user',
                     'date_of_removal'=>"DATE_FORMAT(mg.date_of_removal,'%m/%d/%Y')",
                     'trans_mg.remark',
                ]
                )
              ->join([
                    'table' => 'members_groups',
                    'alias' => 'mg', 
                    'type' => 'LEFT',
                    'conditions' =>"u.id=mg.user_id",
                ])  
              ->join([
                    'table' => 'groups',
                    'alias' => 'g', 
                    'type' => 'LEFT',
                    'conditions' =>"mg.group_id=g.id",
                ])  
               ->join([
                    'table' => 'users',
                    'alias' => 'trans_u', 
                    'type' => 'LEFT',
                    'conditions' =>"mg.new_user_id=trans_u.id and mg.is_transfer_user=1",
                ])  
               ->join([
                    'table' => 'groups',
                    'alias' => 'trans_g', 
                    'type' => 'LEFT',
                    'conditions' =>"mg.group_id=trans_g.id and mg.is_transfer_user=1",
                ])  
               ->join([
                    'table' => 'members_groups',
                    'alias' => 'trans_mg', 
                    'type' => 'LEFT',
                    'conditions' =>"mg.group_id=trans_mg.group_id and mg.new_user_id=trans_mg.user_id  and mg.is_transfer_user=1",
                ])  
              // ->join([
              //       'table' => 'users',
              //       'alias' => 'branch', 
              //       'type' => 'LEFT',
              //       'conditions' =>"u.created_by=u.id",
              //   ])  
              ->where([ 
                    'g.created_date >= '=>date('Y-m-d',strtotime($post['start'])),
                    'g.created_date <= '=>date('Y-m-d',strtotime($post['end']))
                ])
              ->where($role_wise_conditions)
              ->toArray();  
              // echo $users;exit;
          return $users;    
      }

      function getDayBookLists($post, $user_id,$user_role,$created_by){
        //get receipt data
        $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
        $query = $PaymentsTable->find();   
        $role_wise_conditionsr=$this->getRoleWiseConditions($user_id,$user_role,$created_by,'g');
        $where_Conditions = [
                              'p.date >='=>date('Y-m-d',strtotime($post['start'])),
                              'p.date <='=>date('Y-m-d',strtotime($post['end']))
                            ]; 

        $receipts = $query->select([ 
            'pid' =>'p.id',
            'receipt_date'=>"DATE_FORMAT(p.date,'%m/%d/%Y')",
            'receipt_name' => $query->func()->concat(['UPPER(SUBSTRING(u.first_name, 1, 1)), LOWER(SUBSTRING(u.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(u.middle_name, 1, 1)), LOWER(SUBSTRING(u.middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(u.last_name, 1, 1)), LOWER(SUBSTRING(u.last_name, 2))' => 'identifier']),
            'receipt_subcription' => 'p.subscription_amount',
            'receipt_interest' => 'p.late_fee',
            'receipt_total' => 'p.total_amount',
            'receipt_no',
            'p.received_by',
            'p.remark'
                ])
                ->join([
                    'table' => 'groups',
                    'alias' => 'g', 
                    'conditions' =>'g.id = p.group_id',
                ]) 
                ->join([
                    'table' => 'users',
                    'alias' => 'u', 
                    'conditions' =>'p.user_id = u.id',
                ]) 
              ->where($where_Conditions)
              ->where($role_wise_conditionsr)  
              ->order(['p.id' => 'ASC'])->toArray();  
          // echo '$receipts <pre>';print_r($receipts);exit;    

          //Deposit in the bank
          $deposit_in_bank = [];
          if(!empty($receipts)){
            $received_by_const = Configure::read('received_by');    
            foreach($receipts as $key=> $receipt){
                 $deposit_in_bank[$key]['receipt_date'] = $receipt['receipt_date'];
                $deposit_in_bank[$key]['receipt_name'] = $receipt['receipt_name'];
                $deposit_in_bank[$key]['deposit_in_bank_amount'] = $receipt['receipt_total'];
                $deposit_in_bank[$key]['pv_total'] = $receipt['receipt_total'];
                $deposit_in_bank[$key]['remark'] = $received_by_const[$receipt['received_by']];
                $deposit_in_bank[$key]['referece_no'] = $receipt['receipt_no'];
            }
          }

          //get payment voucher data
          $PaymentVouchersTable = TableRegistry::get('pv', ['table' => 'payment_vouchers']);
          $query = $PaymentVouchersTable->find();   
          $role_wise_conditionspv=$this->getRoleWiseConditions($user_id,$user_role,$created_by,'g');
          $where_Conditions_pv = [
                                  'pv.date >='=>date('Y-m-d',strtotime($post['start'])),
                                  'pv.date <='=>date('Y-m-d',strtotime($post['end']))
                                ]; 

          $payment_vouchers = $query->select([ 
            'pvid' =>'pv.id',
            'receipt_date'=>"DATE_FORMAT(pv.date,'%m/%d/%Y')",
            'receipt_name' => $query->func()->concat(['UPPER(SUBSTRING(u.first_name, 1, 1)), LOWER(SUBSTRING(u.first_name, 2))' => 'identifier', ' ','UPPER(SUBSTRING(u.middle_name, 1, 1)), LOWER(SUBSTRING(u.middle_name, 2))' => 'identifier', ' ', 'UPPER(SUBSTRING(u.last_name, 1, 1)), LOWER(SUBSTRING(u.last_name, 2))' => 'identifier']),
            'pv_total' => 'pv.total',
            'expenditure_foremans_commission' =>'pv.foreman_commission',
            'referece_no'=>'pv.payment_voucher_no',
            'pv.remark',
            'other'=>'pv.gst'
                ])
                ->join([
                    'table' => 'groups',
                    'alias' => 'g', 
                    'conditions' =>'g.id = pv.group_id',
                ]) 
                ->join([
                    'table' => 'users',
                    'alias' => 'u', 
                    'conditions' =>'pv.user_id = u.id',
                ]) 
              ->where($where_Conditions_pv)  
              ->where($role_wise_conditionspv)
              ->order(['pv.id' => 'ASC'])->toArray();  
          // echo '$payment_vouchers <pre>';print_r($payment_vouchers);//exit;

          $OtherPaymentsTable = TableRegistry::get('op', ['table' => 'other_payments']);
          $query = $OtherPaymentsTable->find();   
          $role_wise_conditionsop=$this->getRoleWiseConditions($user_id,$user_role,$created_by,'op');
          $where_Conditions_op = [
                                   'op.date >='=>date('Y-m-d',strtotime($post['start'])),
                                   'op.date <='=>date('Y-m-d',strtotime($post['end']))
                                ]; 

          $other_payments = $query->select([ 
            'opid' =>'op.id',
            'receipt_date'=>"DATE_FORMAT(op.date,'%m/%d/%Y')",
            'receipt_name' => 'op.paid_to_name',
            'pv_total' => 'op.total_amount_paid_rs',
            'referece_no'=>'op.other_payment_no',
            'op.remark',
            'other'=>'op.gst'
                ]) 
              ->where($where_Conditions_op)  
              ->where($role_wise_conditionsop)
              ->order(['op.id' => 'ASC'])->toArray();  
          // echo '$other_payments <pre>';print_r($other_payments);//exit;


          //merge all data
          $final_data = array_merge($receipts,$deposit_in_bank,$payment_vouchers,$other_payments);
          // echo '$final_data <pre>';print_r($final_data); 

          // $totalsByDate = [];
          //   foreach ($array as $element) if (($date = strtotime($element->thedate)) and is_numeric($element->theadults)) {
          //       $totalsByDate[$date] += $element->theadults;
          //   }
          //   ksort($totalsByDate);
          //   foreach ($totalsByDate as $date => $total) {
          //       echo "On " . date("Y-m-d", $date) . " there were " . $total " adults.\n";
          //   }

          // Sort the array 
            usort($final_data,function($a, $b) {
                $datetime1 = strtotime($a['receipt_date']);
                $datetime2 = strtotime($b['receipt_date']);
                return $datetime1 - $datetime2;
            });
            //echo '$final_data bef <pre>';print_r($final_data);exit;
           $totalsByDate = [];
           $date = ''; 
           $date_wise_total_index_cnt = 0;
            $subscription  =0;
            $pv_total  =0;
            foreach ($final_data as $key=> $element) { 
                $date_wise_total_index = 0;
                $subscription_sum = ((isset($element['receipt_subcription']) && ($element['receipt_subcription']>0) ?  $element['receipt_subcription'] : 0)
                        + (isset($element['receipt_interest']) && ($element['receipt_interest']>0) ?  $element['receipt_interest'] : 0)
                            +(isset($element['other']) && ($element['other']>0) ?  $element['other'] : 0));

                 $pv_sum = (isset($element['pv_total']) && ($element['pv_total']>0) ?  $element['pv_total'] : 0)
                    +(isset($element['expenditure_foremans_commission']) && ($element['expenditure_foremans_commission']>0)  ?  $element['expenditure_foremans_commission'] : 0)
                     +(isset($element['deposit_in_bank_amount']) && ($element['deposit_in_bank_amount']>0)  ?  $element['deposit_in_bank_amount'] : 0); 

                if (($date == strtotime($element['receipt_date']))) {
                        $subscription = $subscription + $subscription_sum;  
                        $pv_total = $pv_total +  $pv_sum; 
                }else{
                    if($key >0 || $date ==''){
                        $subscription = $subscription_sum;
                        $pv_total =$pv_sum ; 
                    }   

                    if(($key>0) && $date!='')
                    {
                        $date_wise_total_index = $key;
                        $date_wise_total_index_cnt++;
                    }
                } 
  //echo '<br/>======================<br/> '.$date_wise_total_index .($key+1). '== '.count($final_data).'$element <pre>';print_r($element);
                if($date_wise_total_index > 0){ 

                      if($date_wise_total_index_cnt>1){
                         $date_wise_total_index = $date_wise_total_index +  ($date_wise_total_index_cnt-1);
                      }
                    $totalsByDate[$date]['date_wise_total_index']  =$date_wise_total_index; 
                }
                if(($key+1) == count($final_data)){
                    $totalsByDate[strtotime($element['receipt_date'])]['date_wise_total_index']  = 'last';
                }
                
                $totalsByDate[strtotime($element['receipt_date'])]['subscription'] = $subscription;
                $totalsByDate[strtotime($element['receipt_date'])]['pv_totals'] = $pv_total; 
                $totalsByDate[strtotime($element['receipt_date'])]['date_wise_total'] = 1; 
                

               // echo' totalsByDate <pre>';print_r($totalsByDate);  
                $date = strtotime($element['receipt_date']);
            }
            ksort($totalsByDate);
            if(isset($totalsByDate ) && !empty($totalsByDate)){
                foreach($totalsByDate as $val){ 
                    $data=[];
                    if(isset($val['date_wise_total_index'])){
                        if($val['date_wise_total_index'] == 'last'){
                            $data[count($final_data)] = $val;
                            $val['date_wise_total_index'] = count($final_data);
                        }else{
                            $data[$val['date_wise_total_index']] = $val;
                        }
                        array_splice( $final_data, $val['date_wise_total_index'], 0, $data);    
                    }
                }   
            }
            //echo '$totalsByDate ff <pre>';print_r($totalsByDate);
            //echo '$final_data ff <pre>';print_r($final_data);
            //exit; 
            
          return $final_data; 
      }


}
     
?>