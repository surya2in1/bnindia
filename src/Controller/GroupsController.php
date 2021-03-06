<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupsController extends AppController
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
             $output = $this->Groups->GetData();
             // debug($output);exit;
             echo json_encode($output);exit;
        }
        
    }

    /**
    * Group list
    */
    public function groups()
    {
        $groups = $this->paginate($this->Groups);

        $this->set(compact('groups'));
        
    }

    /**
     * View method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $group = $this->Groups->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('group'));
    }
    /*
    ** add editgroup
    */
     function groupform($id=null){
        $this->viewBuilder()->setLayout('admin');
        if(isset($_POST['id']) && ($_POST['id'] > 0)){
            $id =  $_POST['id'];
        }
        if($id>0){
            $group = $this->Groups->get($id, [
                'contain' => [],
            ]);       
        }else{
            $group = $this->Groups->newEmptyEntity();
        }
        // echo 'sdf';exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();
           // echo '<pre>';print_r($group); 
            $post['date'] = date('Y-m-d',strtotime($post['date'])); 
             // echo '<pre>';print_r($post);exit;
            $group = $this->Groups->patchEntity($group, $post);
            if ($this->Groups->save($group)) {
                echo 1;
            }else{
                 $validationErrors = $group->getErrors();
                // echo '<pre>';print_r($group->getErrors());
                if(isset($validationErrors['group_number']['unique']) && !empty($validationErrors['group_number']['unique'])){
                    echo 'group_number_unique';
                }else{
                    echo 0;
                } 
            }
            exit;
        }
        //echo '<pre>';print_r($group);exit();
        $this->set(compact('group'));
     }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('admin');    
        $group = $this->Groups->newEmptyEntity();
        if ($this->request->is('post')) {
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $this->set(compact('group'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $group = $this->Groups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $this->set(compact('group'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'delete']);
        $MembersGroupsTable = TableRegistry::get('MembersGroups');
        $membergroup = $MembersGroupsTable->find('all')->where(['group_id'=>$id])->first();
        if($membergroup){
            echo 'group_associated_with_members';
        }else{
            $group = $this->Groups->get($id);
            if ($this->Groups->delete($group)) {
                echo 1;
            } else {
                echo 0;
            }
        }
        exit;
    }
}

