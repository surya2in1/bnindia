<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */
?>
<div class="payments index content">
    <?= $this->Html->link(__('New Payment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Payments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('receipt_no') ?></th>
                    <th><?= $this->Paginator->sort('due_date') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('group_id') ?></th>
                    <th><?= $this->Paginator->sort('subscriber_ticket_no') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('instalment_no') ?></th>
                    <th><?= $this->Paginator->sort('instalment_month') ?></th>
                    <th><?= $this->Paginator->sort('subscription_amount') ?></th>
                    <th><?= $this->Paginator->sort('late_fee') ?></th>
                    <th><?= $this->Paginator->sort('received_by') ?></th>
                    <th><?= $this->Paginator->sort('cash_received_date') ?></th>
                    <th><?= $this->Paginator->sort('cheque_no') ?></th>
                    <th><?= $this->Paginator->sort('cheque_date') ?></th>
                    <th><?= $this->Paginator->sort('cheque_bank_details') ?></th>
                    <th><?= $this->Paginator->sort('cheque_drown_on') ?></th>
                    <th><?= $this->Paginator->sort('direct_debit_date') ?></th>
                    <th><?= $this->Paginator->sort('direct_debit_transaction_no') ?></th>
                    <th><?= $this->Paginator->sort('remark') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?= $this->Number->format($payment->id) ?></td>
                    <td><?= h($payment->receipt_no) ?></td>
                    <td><?= h($payment->due_date) ?></td>
                    <td><?= h($payment->date) ?></td>
                    <td><?= $payment->has('group') ? $this->Html->link($payment->group->id, ['controller' => 'Groups', 'action' => 'view', $payment->group->id]) : '' ?></td>
                    <td><?= h($payment->subscriber_ticket_no) ?></td>
                    <td><?= $this->Number->format($payment->user_id) ?></td>
                    <td><?= $this->Number->format($payment->instalment_no) ?></td>
                    <td><?= $this->Number->format($payment->instalment_month) ?></td>
                    <td><?= $this->Number->format($payment->subscription_amount) ?></td>
                    <td><?= $this->Number->format($payment->late_fee) ?></td>
                    <td><?= $this->Number->format($payment->received_by) ?></td>
                    <td><?= h($payment->cash_received_date) ?></td>
                    <td><?= h($payment->cheque_no) ?></td>
                    <td><?= h($payment->cheque_date) ?></td>
                    <td><?= $this->Number->format($payment->cheque_bank_details) ?></td>
                    <td><?= $this->Number->format($payment->cheque_drown_on) ?></td>
                    <td><?= h($payment->direct_debit_date) ?></td>
                    <td><?= h($payment->direct_debit_transaction_no) ?></td>
                    <td><?= h($payment->remark) ?></td>
                    <td><?= h($payment->created) ?></td>
                    <td><?= h($payment->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $payment->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payment->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
