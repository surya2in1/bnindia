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
            <?= $this->Html->link(__('List Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="payments form content">
            <?= $this->Form->create($payment) ?>
            <fieldset>
                <legend><?= __('Add Payment') ?></legend>
                <?php
                    echo $this->Form->control('receipt_no');
                    echo $this->Form->control('due_date');
                    echo $this->Form->control('date');
                    echo $this->Form->control('group_id', ['options' => $groups]);
                    echo $this->Form->control('subscriber_ticket_no');
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('instalment_no');
                    echo $this->Form->control('instalment_month');
                    echo $this->Form->control('subscription_amount');
                    echo $this->Form->control('late_fee');
                    echo $this->Form->control('received_by');
                    echo $this->Form->control('cash_received_date');
                    echo $this->Form->control('cheque_no');
                    echo $this->Form->control('cheque_date');
                    echo $this->Form->control('cheque_bank_details');
                    echo $this->Form->control('cheque_drown_on');
                    echo $this->Form->control('direct_debit_date');
                    echo $this->Form->control('direct_debit_transaction_no');
                    echo $this->Form->control('remark');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
