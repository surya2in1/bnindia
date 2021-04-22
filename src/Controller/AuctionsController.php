<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;

/**
 * Auctions Controller
 *
 * @property \App\Model\Table\AuctionsTable $Auctions
 * @method \App\Model\Entity\Auction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuctionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    { 
        $this->viewBuilder()->setLayout('admin');    
        if ($this->request->is('post')) { 
             $output = $this->Auctions->GetData();
             echo json_encode($output);exit;
        }
    }

    /*
    ** add edit auction
    */
     function auctionform($id=null){
        $this->viewBuilder()->setLayout('admin');
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        } 
        $selected_group_members = [];  
        $auction = [];
        if($id>0){
            $auction = $this->Auctions->get($id, [
                'contain' => ['Users','Members'],
            ]); 
            $selected_group_members = $this->Common->getGroupMember($auction->group_id); 
        }else{
            $auction = $this->Auctions->newEmptyEntity();
        }
         
        //Get all fulle member groups  
        $GroupsTable = TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'group_code' 
                                    ])
                    ->where(['status'=>0,'is_all_auction_completed' => 0])->toArray();

        //echo '<pre>';print_r($auction);exit();
        $this->set(compact('auction','groups','selected_group_members'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData(); 
           //convert dates to db field format
            if(strtotime($post['auction_date']) > 0){
                $post['auction_date'] = date('Y-m-d',strtotime($post['auction_date']));
            }
           // echo '<pre>';print_r($post);// exit;  
            $auction = $this->Auctions->patchEntity($auction, $post);
            if ($result = $this->Auctions->save($auction)) { 
                //check if all auction complete then update groups 
                $groupAuctionCount = $this->Auctions->find('all', array('conditions' => ['group_id' => $post['group_id']]));
                if($groupAuctionCount->count() == $post['total_members']){
                    $GroupsTable = TableRegistry::get('Groups');
                    $query = $GroupsTable->query();
                            $query->update()
                                ->set(['is_all_auction_completed' => 1])
                                ->where(['id' => $post['group_id']])
                                ->execute();
                }
                echo 1;
            }else{
                $validationErrors = $auction->getErrors();
                echo 0;
            }
            exit;
        }
     }


    // Get selected member group list
    function getMembersByGrooupId(){
        $post = $this->request->getData();
        $group_id = isset($post['group_id']) && $post['group_id']>0  ? $post['group_id'] : 0;
        $selected_group_members = []; 
        if($group_id>0){ 
            $selected_group_members = $this->Common->getGroupMember($group_id);
        }
        echo json_encode($selected_group_members);exit;
    }
}
