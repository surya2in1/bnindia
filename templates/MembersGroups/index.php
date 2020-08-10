<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MembersGroup[]|\Cake\Collection\CollectionInterface $membersGroups
 */
?>
<div class="membersGroups index content">
    <?= $this->Html->link(__('New Members Group'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Members Groups') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('member_id') ?></th>
                    <th><?= $this->Paginator->sort('group_id') ?></th>
                    <th><?= $this->Paginator->sort('created_date') ?></th>
                    <th><?= $this->Paginator->sort('modified_date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($membersGroups as $membersGroup): ?>
                <tr>
                    <td><?= $this->Number->format($membersGroup->id) ?></td>
                    <td><?= $this->Number->format($membersGroup->member_id) ?></td>
                    <td><?= $membersGroup->has('group') ? $this->Html->link($membersGroup->group->id, ['controller' => 'Groups', 'action' => 'view', $membersGroup->group->id]) : '' ?></td>
                    <td><?= h($membersGroup->created_date) ?></td>
                    <td><?= h($membersGroup->modified_date) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $membersGroup->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $membersGroup->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $membersGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $membersGroup->id)]) ?>
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
