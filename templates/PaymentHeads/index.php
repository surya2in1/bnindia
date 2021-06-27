<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentHead[]|\Cake\Collection\CollectionInterface $paymentHeads
 */
?>
<div class="paymentHeads index content">
    <?= $this->Html->link(__('New Payment Head'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Payment Heads') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('payment_head') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paymentHeads as $paymentHead): ?>
                <tr>
                    <td><?= $this->Number->format($paymentHead->id) ?></td>
                    <td><?= h($paymentHead->payment_head) ?></td>
                    <td><?= h($paymentHead->created) ?></td>
                    <td><?= h($paymentHead->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $paymentHead->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $paymentHead->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $paymentHead->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentHead->id)]) ?>
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
