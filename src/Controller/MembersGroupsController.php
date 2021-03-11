<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MembersGroups Controller
 *
 * @property \App\Model\Table\MembersGroupsTable $MembersGroups
 * @method \App\Model\Entity\MembersGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MembersGroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Members', 'Groups'],
        ];
        $membersGroups = $this->paginate($this->MembersGroups);

        $this->set(compact('membersGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Members Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $membersGroup = $this->MembersGroups->get($id, [
            'contain' => ['Members', 'Groups'],
        ]);

        $this->set(compact('membersGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $membersGroup = $this->MembersGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $membersGroup = $this->MembersGroups->patchEntity($membersGroup, $this->request->getData());
            if ($this->MembersGroups->save($membersGroup)) {
                $this->Flash->success(__('The members group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The members group could not be saved. Please, try again.'));
        }
        $members = $this->MembersGroups->Members->find('list', ['limit' => 200]);
        $groups = $this->MembersGroups->Groups->find('list', ['limit' => 200]);
        $this->set(compact('membersGroup', 'members', 'groups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Members Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $membersGroup = $this->MembersGroups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $membersGroup = $this->MembersGroups->patchEntity($membersGroup, $this->request->getData());
            if ($this->MembersGroups->save($membersGroup)) {
                $this->Flash->success(__('The members group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The members group could not be saved. Please, try again.'));
        }
        $members = $this->MembersGroups->Members->find('list', ['limit' => 200]);
        $groups = $this->MembersGroups->Groups->find('list', ['limit' => 200]);
        $this->set(compact('membersGroup', 'members', 'groups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Members Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $membersGroup = $this->MembersGroups->get($id);
        if ($this->MembersGroups->delete($membersGroup)) {
            $this->Flash->success(__('The members group has been deleted.'));
        } else {
            $this->Flash->error(__('The members group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Strict Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteGroupUser($id = null)
    {
        $this->request->allowMethod(['get', 'delete']); 
        $membersGroup = $this->MembersGroups->get($id);
        if ($this->MembersGroups->delete($membersGroup)) {
            echo 1;
        } else {
            echo 0;
        } 
        exit();
    }
}
