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
    public function initialize(): void
    {
        parent::initialize(); 
        $this->loadComponent('Common');
    }

    function receiptStatement(){
        $this->viewBuilder()->setLayout('admin'); 
 
        $GroupsTable= TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                    'keyField' => 'id',
                                    'valueField' => 'group_code'
                                ])
                 ->where(['status ' => 0,'created_by'=>$this->Auth->user('id')])->toArray();
        $this->set(compact('groups'));
    }

    public function pdf()
    { 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->request->getData();   
            $report = $this->Common->getReceiptStatement($post);  
            $this->viewBuilder()->enableAutoLayout(false);    
            $this->viewBuilder()->setClassName('CakePdf.Pdf'); 
            $this->viewBuilder()->setLayout('admin');
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    // 'render' => 'browser',
                    'download' => true, // This can be omitted if "filename" is specified.
                   'filename' => 'receipt_statement' .'.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );
            //echo '$report<pre>';print_r($report);  exit;

            $this->set('report', $report);
        }
    }

     /**
     * instalmentDetails method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function instalmentDetails()
    { 
        $this->viewBuilder()->setLayout('admin');  
        $GroupsTable= TableRegistry::get('Groups');
        $groups = $GroupsTable->find('list', [
                                    'keyField' => 'id',
                                    'valueField' => 'group_code'
                                ])
                 ->where(['status ' => 0])->toArray();
        $this->set(compact('groups'));
    } 
    
    function instalmentDetailsPdf(){

    }
}
