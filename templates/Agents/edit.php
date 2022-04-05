<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agent $agent
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $agent->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $agent->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Agents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="agents form content">
            <?= $this->Form->create($agent) ?>
            <fieldset>
                <legend><?= __('Edit Agent') ?></legend>
                <?php
                    echo $this->Form->control('agent_code');
                    echo $this->Form->control('name');
                    echo $this->Form->control('address');
                    echo $this->Form->control('mobile_number');
                    echo $this->Form->control('email');
                    echo $this->Form->control('address_proof');
                    echo $this->Form->control('pan_card');
                    echo $this->Form->control('photo');
                    echo $this->Form->control('educational_proof');
                    echo $this->Form->control('bank_name');
                    echo $this->Form->control('account_no');
                    echo $this->Form->control('ifsc_code');
                    echo $this->Form->control('branch_name');
                    echo $this->Form->control('bank_address');
                    echo $this->Form->control('created_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
