<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $group->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $group->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="groups form content">
            <?= $this->Form->create($group) ?>
            <fieldset>
                <legend><?= __('Edit Group') ?></legend>
                <?php
                    echo $this->Form->control('group_number');
                    echo $this->Form->control('chit_amount');
                    echo $this->Form->control('total_number');
                    echo $this->Form->control('premium');
                    echo $this->Form->control('gov_reg_no');
                    echo $this->Form->control('date');
                    echo $this->Form->control('status');
                    echo $this->Form->control('no_of_months');
                    echo $this->Form->control('created_date');
                    echo $this->Form->control('modified_date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
