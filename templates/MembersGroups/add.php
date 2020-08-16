<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MembersGroup $membersGroup
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Members Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="membersGroups form content">
            <?= $this->Form->create($membersGroup) ?>
            <fieldset>
                <legend><?= __('Add Members Group') ?></legend>
                <?php
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('group_id', ['options' => $groups]);
                    echo $this->Form->control('created_date');
                    echo $this->Form->control('modified_date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
