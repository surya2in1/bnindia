<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PaymentHeads Controller
 *
 * @property \App\Model\Table\PaymentHeadsTable $PaymentHeads
 * @method \App\Model\Entity\PaymentHead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentHeadsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $paymentHeads = $this->paginate($this->PaymentHeads);

        $this->set(compact('paymentHeads'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment Head id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paymentHead = $this->PaymentHeads->get($id, [
            'contain' => ['OtherPayments'],
        ]);

        $this->set(compact('paymentHead'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $paymentHead = $this->PaymentHeads->newEmptyEntity();
        if ($this->request->is('post')) {
            $paymentHead = $this->PaymentHeads->patchEntity($paymentHead, $this->request->getData());
            if ($this->PaymentHeads->save($paymentHead)) {
                $this->Flash->success(__('The payment head has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment head could not be saved. Please, try again.'));
        }
        $this->set(compact('paymentHead'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment Head id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $paymentHead = $this->PaymentHeads->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentHead = $this->PaymentHeads->patchEntity($paymentHead, $this->request->getData());
            if ($this->PaymentHeads->save($paymentHead)) {
                $this->Flash->success(__('The payment head has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment head could not be saved. Please, try again.'));
        }
        $this->set(compact('paymentHead'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment Head id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentHead = $this->PaymentHeads->get($id);
        if ($this->PaymentHeads->delete($paymentHead)) {
            $this->Flash->success(__('The payment head has been deleted.'));
        } else {
            $this->Flash->error(__('The payment head could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
