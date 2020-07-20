<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RolePermissions Controller
 *
 * @property \App\Model\Table\RolePermissionsTable $RolePermissions
 * @method \App\Model\Entity\RolePermission[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolePermissionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Roles', 'Modules', 'Permissions'],
        ];
        $rolePermissions = $this->paginate($this->RolePermissions);

        $this->set(compact('rolePermissions'));
    }

    /**
     * View method
     *
     * @param string|null $id Role Permission id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rolePermission = $this->RolePermissions->get($id, [
            'contain' => ['Roles', 'Modules', 'Permissions'],
        ]);

        $this->set(compact('rolePermission'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rolePermission = $this->RolePermissions->newEmptyEntity();
        if ($this->request->is('post')) {
            $rolePermission = $this->RolePermissions->patchEntity($rolePermission, $this->request->getData());
            if ($this->RolePermissions->save($rolePermission)) {
                $this->Flash->success(__('The role permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role permission could not be saved. Please, try again.'));
        }
        $roles = $this->RolePermissions->Roles->find('list', ['limit' => 200]);
        $modules = $this->RolePermissions->Modules->find('list', ['limit' => 200]);
        $permissions = $this->RolePermissions->Permissions->find('list', ['limit' => 200]);
        $this->set(compact('rolePermission', 'roles', 'modules', 'permissions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role Permission id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rolePermission = $this->RolePermissions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rolePermission = $this->RolePermissions->patchEntity($rolePermission, $this->request->getData());
            if ($this->RolePermissions->save($rolePermission)) {
                $this->Flash->success(__('The role permission has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The role permission could not be saved. Please, try again.'));
        }
        $roles = $this->RolePermissions->Roles->find('list', ['limit' => 200]);
        $modules = $this->RolePermissions->Modules->find('list', ['limit' => 200]);
        $permissions = $this->RolePermissions->Permissions->find('list', ['limit' => 200]);
        $this->set(compact('rolePermission', 'roles', 'modules', 'permissions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role Permission id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rolePermission = $this->RolePermissions->get($id);
        if ($this->RolePermissions->delete($rolePermission)) {
            $this->Flash->success(__('The role permission has been deleted.'));
        } else {
            $this->Flash->error(__('The role permission could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
