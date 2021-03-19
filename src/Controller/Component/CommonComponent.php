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

	function getUserMembers($user_id){
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
}
?>