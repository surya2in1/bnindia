<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentHead $paymentHead
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Payment Head'), ['action' => 'edit', $paymentHead->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Payment Head'), ['action' => 'delete', $paymentHead->id], ['confirm' => __('Are you sure you want to delete # {0}?', $paymentHead->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Payment Heads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Payment Head'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="paymentHeads view content">
            <h3><?= h($paymentHead->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Payment Head') ?></th>
                    <td><?= h($paymentHead->payment_head) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($paymentHead->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($paymentHead->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($paymentHead->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Other Payments') ?></h4>
                <?php if (!empty($paymentHead->other_payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Payment Head Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Total Amount') ?></th>
                            <th><?= __('Gst') ?></th>
                            <th><?= __('Less Tds') ?></th>
                            <th><?= __('Total Amount Paid Rs') ?></th>
                            <th><?= __('Cheque Transaction No') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($paymentHead->other_payments as $otherPayments) : ?>
                        <tr>
                            <td><?= h($otherPayments->id) ?></td>
                            <td><?= h($otherPayments->payment_head_id) ?></td>
                            <td><?= h($otherPayments->date) ?></td>
                            <td><?= h($otherPayments->user_id) ?></td>
                            <td><?= h($otherPayments->total_amount) ?></td>
                            <td><?= h($otherPayments->gst) ?></td>
                            <td><?= h($otherPayments->less_tds) ?></td>
                            <td><?= h($otherPayments->total_amount_paid_rs) ?></td>
                            <td><?= h($otherPayments->cheque_transaction_no) ?></td>
                            <td><?= h($otherPayments->created) ?></td>
                            <td><?= h($otherPayments->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OtherPayments', 'action' => 'view', $otherPayments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OtherPayments', 'action' => 'edit', $otherPayments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'OtherPayments', 'action' => 'delete', $otherPayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $otherPayments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
