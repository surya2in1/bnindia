<?php
namespace App\Controller\Component;
 
use Cake\Controller\Component;
use Cake\Mailer\TransportFactory;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;

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
                                    ->select(['id','name' => $q->func()->concat(['Users.first_name' => 'identifier', ' ','middle_name' => 'identifier', ' ', 'last_name' => 'identifier'])])
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
    $instalment_nos = $query->select(['pid' => $query->func()->max('p.id'),'Auctions.auction_no','Auctions.id'])
           ->join([
              'table' => 'payments',
              'alias' => 'p',
              'type' => 'LEFT',
              'conditions' => 'p.auction_id=Auctions.id',
          ]) 
          ->where(['Auctions.group_id'=>$group_id])
          ->group('Auctions.auction_no HAVING pid NOT IN (SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = '.$member_id.' and group_id = '.$group_id.' and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id  ASC) or pid is null')
          ->toArray(); 
    // echo '111<pre>';print_r($instalment_nos);exit;
          return $instalment_nos;
  }

  
}
?>