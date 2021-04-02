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
        $selected_group_members =[];
        $groupmembers =[];
        $group_members= TableRegistry::get('MembersGroups');
        $group_members = $group_members->find('all', [
            'contain' => [
                             'Groups' => function($q) use ($group_id) {
                                return $q
                                    ->select(['id','chit_amount','total_number'])
                                    ->contain(['Auctions' => function($q) use ($group_id) {
                                          return $q
                                              ->select(['Auctions.group_id',
                                                'auction_count' => $q->func()->count('Auctions.id')
                                                ])
                                              ->where(['Auctions.group_id'=>$group_id]);
                                        }, ])
                                    ->where(['Groups.id'=>$group_id,'Groups.is_all_auction_completed' => 0]);
                              }, 
                             'Users' => function($q) use ($group_id) {
                                return $q
                                    ->select(['id','name' => $q->func()->concat(['Users.first_name' => 'identifier', ' ','middle_name' => 'identifier', ' ', 'last_name' => 'identifier'])])
                                    ->where(['group_id'=>$group_id]);
                            },    
                         ],
        ])->toArray(); 
        if(!empty($group_members)){
            $groupmembers['auction_count'] = isset($group_members[0]['group']['auctions'][0]['auction_count']) && ($group_members[0]['group']['auctions'][0]['auction_count'] > 0) ? ($group_members[0]['group']['auctions'][0]['auction_count']+1) : 1;
            $groupmembers['groups'] = isset($group_members[0]['group']) ? $group_members[0]['group'] : '';
            foreach ($group_members as $key => $value) { 
                $selected_group_members[$value->user_id] = $value->name; 
            }
        }
        $groupmembers['group_members'] = $selected_group_members;
        // echo 'group_members<pre>';print_r($groupmembers);exit;
        return $groupmembers;
  }
}
?>