<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Payment'), ['action' => 'edit', $payment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Payment'), ['action' => 'delete', $payment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Payment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="payments view content">
            <h3><?= h($payment->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Receipt No') ?></th>
                    <td><?= h($payment->receipt_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Group') ?></th>
                    <td><?= $payment->has('group') ? $this->Html->link($payment->group->id, ['controller' => 'Groups', 'action' => 'view', $payment->group->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Subscriber Ticket No') ?></th>
                    <td><?= h($payment->subscriber_ticket_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cheque No') ?></th>
                    <td><?= h($payment->cheque_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Direct Debit Transaction No') ?></th>
                    <td><?= h($payment->direct_debit_transaction_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Remark') ?></th>
                    <td><?= h($payment->remark) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($payment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Member Id') ?></th>
                    <td><?= $this->Number->format($payment->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instalment No') ?></th>
                    <td><?= $this->Number->format($payment->instalment_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instalment Month') ?></th>
                    <td><?= $this->Number->format($payment->instalment_month) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subscription Amount') ?></th>
                    <td><?= $this->Number->format($payment->subscription_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Late Fee') ?></th>
                    <td><?= $this->Number->format($payment->late_fee) ?></td>
                </tr>
                <tr>
                    <th><?= __('Received By') ?></th>
                    <td><?= $this->Number->format($payment->received_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cheque Bank Details') ?></th>
                    <td><?= $this->Number->format($payment->cheque_bank_details) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cheque Drown On') ?></th>
                    <td><?= $this->Number->format($payment->cheque_drown_on) ?></td>
                </tr>
                <tr>
                    <th><?= __('Due Date') ?></th>
                    <td><?= h($payment->due_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($payment->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cash Received Date') ?></th>
                    <td><?= h($payment->cash_received_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cheque Date') ?></th>
                    <td><?= h($payment->cheque_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Direct Debit Date') ?></th>
                    <td><?= h($payment->direct_debit_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($payment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($payment->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
