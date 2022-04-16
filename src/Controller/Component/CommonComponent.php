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

  function getReceiptStatement($post,$user_id){
    $payments =[];
    if(isset($post['start']) && isset($post['end']) && isset($post['search_by'])){
       $post['start']= strtotime($post['start']) > 0 ? date('Y-m-d',strtotime($post['start'])) : ''; 
       $post['end']= strtotime($post['end']) > 0 ? date('Y-m-d',strtotime($post['end'])) : '';
        //echo '$post<pre>';print_r($post); 
       $where_Conditions = [];
       if($post['search_by'] == 'group_by' || $post['search_by'] == 'member_by'){
          $where_Conditions[]= ['g.id'=>$post['group_id']];
       }
       if($post['search_by'] == 'member_by'){
          $where_Conditions[]= ['u.id'=>$post['user_id']];
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
            ->where(['p.date >='=> $post['start'],'p.date <='=> $post['end'],'p.created_by'=>$user_id])
            ->where($where_Conditions)
            ->toArray();  
    }
    // echo '$payments<pre>';print_r($payments);  exit;
    return $payments;
  }

  function getInstalmentDetails($post,$user_id){
    $report['payments'] =[];
    $report['all_months_due_amount'] = 0;

    if(isset($post['start']) && isset($post['end']) && isset($post['user_id'])){
       $post['start']= strtotime($post['start']) > 0 ? date('Y-m-d',strtotime($post['start'])) : ''; 
       $post['end']= strtotime($post['end']) > 0 ? date('Y-m-d',strtotime($post['end'])) : '';
        $where_Conditions[]= ['p.user_id'=>$post['user_id']];
        // echo '$post<pre>';print_r($post);

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
            ->where(['p.date >='=> $post['start'],'p.date <='=> $post['end'],'p.created_by'=>$user_id])
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

    public function getSubscribersDetails($post,$user_id)
    {
        $result=[];
        if(isset($post['group_id']) && isset($user_id)){
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
               ->where(['g.id'=>$post['group_id'],'g.created_by'=>$user_id])
               ->toArray();
               // echo '$result<pre>';print_r($result);exit;
        }
        return $result;
    }    

    public function getAuctionsDetails($post,$user_id)
    {
      $post['start']= strtotime($post['start']) > 0 ? date('Y-m-d',strtotime($post['start'])) : ''; 
      $post['end']= strtotime($post['end']) > 0 ? date('Y-m-d',strtotime($post['end'])) : '';  
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
          ->where(['a.auction_date >='=> $post['start'],'a.auction_date <='=> $post['end'],'a.created_by'=>$user_id,'a.group_id'=>$post['group_id']]) 
          ->toArray();  
           // echo '$auctions<pre>';print_r($auctions);  exit;
      return $auctions;    
    }

     function getGroupsDetails($post, $user_id){
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
              ->where(['g.id'=>$post['group_id'],'g.created_by'=>$user_id]) 
              ->first();  
          return $groups;    
      }

      function getUserGroupDetails($post, $user_id){
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
              ->where(['u.id'=>$post['user_id'],'g.created_by'=>$user_id]) 
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

      function getVacantMemberDetails($user_id,$group_id=0){
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
              ->where(['g.created_by'=>$user_id])  
               ->where(['mg.group_id IN '=>$include])  
              ->where($where_Conditions)
              // ->where(['mg.group_id IN '=>" (SELECT group_id FROM auctions WHERE auction_group_due_date < CURRENT_DATE() group by group_id ORDER BY group_id ASC)"])
              ->having(['pi >='=>3,'auction_winner'=>0])
              ->order(['mg.group_id' => 'ASC','mg.user_id'=>'ASC'])->toArray();  
          // echo '$groups <pre>';print_r($groups);exit;    
          return $groups;    
      }

      function getFormanCommissionDetailsPdf($post,$user_id){
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
              ->where(['g.created_by'=>$user_id,'g.id'=>$post['group_id']])   
              ->where(['pv.date >='=> $post['start'],'pv.date <='=> $post['end']]) 
              ->order(['pv.group_id' => 'ASC'])->toArray();  
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

      function getTransferedSubscriberDetails($post,$user_id){
        $MembersGroupsTable = TableRegistry::get('mg', ['table' => 'members_groups']);
        $query = $MembersGroupsTable->find();   
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
              ->where(['g.created_by'=>$user_id,'mg.is_transfer_user'=>1,'g.id'=>$post['group_id']])  
              ->order(['mg.group_id' => 'ASC'])->toArray();  
          // echo '$pv <pre>';print_r($transferedMembers);exit;    
          return $transferedMembers; 
      }

      function getAmountByReceivedBy($received_by,$user_id){
        $conn = ConnectionManager::get('default');
        $sQuery = "call CalculateMoneyNotes($received_by,$user_id);";
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

      function getAllSuccessfullTransaction($user_id){
          $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
          $query = $PaymentsTable->find();     
          $payments = $query->select(['total_fully_paid_interest'=>"count(p.id)"])
              ->where(['p.created_by'=>$user_id,'p.is_installment_complete'=>1]) 
              ->first();  
          return $payments->total_fully_paid_interest;    
      }

      function getGroupCount($user_id){
         $GroupsTable = TableRegistry::get('g', ['table' => 'groups']);
          $query = $GroupsTable->find();     
          $groups = $query->select(['total_groups'=>"count(g.id)"])
              ->where(['g.created_by'=>$user_id]) 
              ->first();  
          return $groups->total_groups;
      }

       function getMemberCount($user_id){
         $UsersTable = TableRegistry::get('u', ['table' => 'users']);
          $query = $UsersTable->find();     
          $members = $query->select(['total_members'=>"count(u.id)"])
                 ->join([
                    'table' => 'roles',
                    'alias' => 'r', 
                    'type' => 'LEFT',
                    'conditions' =>"r.id=u.role_id",
                ]) 
              ->where(['u.created_by'=>$user_id,'u.status'=> 1,'r.name'=>Configure::read('ROLE_MEMBER')]) 
              ->first();  
          return $members->total_members;
      }

       function getAuctionsCount($user_id){
          $AuctionsTable = TableRegistry::get('a', ['table' => 'auctions']);
          $query = $AuctionsTable->find();     
          $auctions = $query->select(['total_auctions'=>"count(a.id)"]) 
              ->where(['a.created_by'=>$user_id]) 
              ->first();  
          return $auctions->total_auctions;
      }
      function getPaymentsCount($user_id){
          $PaymentsTable = TableRegistry::get('p', ['table' => 'payments']);
          $query = $PaymentsTable->find();     
          $payments = $query->select(['total_payments'=>"count(p.id)"]) 
              ->where(['p.created_by'=>$user_id]) 
              ->first();  
          return $payments->total_payments;
      }

    /**
    * this function ussed for image and user documents upload
    * fun used for profile inf and member add edit
    */
    public function userDocUpload($db_upload_field, $post, $path = '', $id=0){
        $name = $post->getClientFilename();
        $filename = '';
        if($name){
            $name = preg_replace('/[(){}]/', '', $name);
            $name = str_replace(' ', '', $name);

            $sffledStr= str_shuffle('encrypt');
            $uniqueString = md5(time().$sffledStr);
             
            //get existing file name
            $AgentsTable = TableRegistry::get('a', ['table' => 'agents']);
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
}
?>