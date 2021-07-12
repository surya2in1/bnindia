<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenDate;
use Cake\Core\Configure;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{
    function receiptStatement(){
        $this->viewBuilder()->setLayout('admin'); 
        $GroupsTable= TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                    'keyField' => 'id',
                                    'valueField' => 'group_code'
                                ])
                 ->where(['status ' => 0])->toArray();
        $this->set(compact('groups'));
                     
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();  
             echo '$post <pre>';print_r($post);exit;
        }
    }

    /**
     * instalmentDetails method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function instalmentDetails()
    { 
        echo 'sfsf';exit;
    } 
 
}
