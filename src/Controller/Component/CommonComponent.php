<?php
namespace App\Controller\Component;
 
use Cake\Controller\Component;
use Cake\Mailer\TransportFactory;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;

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

  function getGroupMember($group_id){
        $groupmembers =[];
        $group_members= TableRegistry::get('MembersGroups');
        $group_members = $group_members->find('all', [
            'contain' => [
                             'Groups' => function($q) use ($group_id) {
                                return $q
                                    ->select(['id','chit_amount','total_number','premium','date','late_fee','group_type'])
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
        ])->toArray(); 
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
      'due_date' => 'Auctions.auction_group_due_date' 
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
}
?>