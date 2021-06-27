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
            <?= $this->Html->link(__('List Payment Heads'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="paymentHeads form content">
            <?= $this->Form->create($paymentHead) ?>
            <fieldset>
                <legend><?= __('Add Payment Head') ?></legend>
                <?php
                    echo $this->Form->control('payment_head');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
