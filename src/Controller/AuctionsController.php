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
        $this->paginate = [
            'contain' => ['Groups'],
        ];
        $auctions = $this->paginate($this->Auctions);

        $this->set(compact('auctions'));
    }

    /**
     * View method
     *
     * @param string|null $id Auction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auction = $this->Auctions->get($id, [
            'contain' => ['Groups'],
        ]);

        $this->set(compact('auction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auction = $this->Auctions->newEmptyEntity();
        if ($this->request->is('post')) {
            $auction = $this->Auctions->patchEntity($auction, $this->request->getData());
            if ($this->Auctions->save($auction)) {
                $this->Flash->success(__('The auction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The auction could not be saved. Please, try again.'));
        }
        $groups = $this->Auctions->Groups->find('list', ['limit' => 200]);
        $this->set(compact('auction', 'groups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Auction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auction = $this->Auctions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auction = $this->Auctions->patchEntity($auction, $this->request->getData());
            if ($this->Auctions->save($auction)) {
                $this->Flash->success(__('The auction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The auction could not be saved. Please, try again.'));
        }
        $groups = $this->Auctions->Groups->find('list', ['limit' => 200]);
        $this->set(compact('auction', 'groups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Auction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auction = $this->Auctions->get($id);
        if ($this->Auctions->delete($auction)) {
            $this->Flash->success(__('The auction has been deleted.'));
        } else {
            $this->Flash->error(__('The auction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

     /*
    ** add edit auction
    */
     function auctionform($id=null){
        $this->viewBuilder()->setLayout('admin');
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }
        if($id>0){
            $auction = $this->Auctions->get($id, [
                'contain' => [],
            ]);       
        }else{
            $auction = $this->Auctions->newEmptyEntity();
        }
        //Get all groups except disable
        $GroupsTable = TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                        'keyField' => 'id',
                                        'valueField' => 'group_code' 
                                    ])
                    ->where(['status !='=>2])->toArray();

        //echo '<pre>';print_r($auction);exit();
        $this->set(compact('auction','groups'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData(); 
           // echo '<pre>';print_r($post); exit;  
            $auction = $this->Auctions->patchEntity($auction, $post);
            if ($result = $this->Auctions->save($auction)) { 
                echo 1;
            }else{
                $validationErrors = $auction->getErrors();
                echo 0;
            }
            exit;
        }
     }
}
