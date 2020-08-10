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
            <?= $this->Html->link(__('Edit Members Group'), ['action' => 'edit', $membersGroup->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Members Group'), ['action' => 'delete', $membersGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membersGroup->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Members Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Members Group'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="membersGroups view content">
            <h3><?= h($membersGroup->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Group') ?></th>
                    <td><?= $membersGroup->has('group') ? $this->Html->link($membersGroup->group->id, ['controller' => 'Groups', 'action' => 'view', $membersGroup->group->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($membersGroup->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Member Id') ?></th>
                    <td><?= $this->Number->format($membersGroup->member_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created Date') ?></th>
                    <td><?= h($membersGroup->created_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified Date') ?></th>
                    <td><?= h($membersGroup->modified_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
