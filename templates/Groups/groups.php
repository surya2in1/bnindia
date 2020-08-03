<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group[]|\Cake\Collection\CollectionInterface $groups
 */
?>
<div class="groups index content">
    <?= $this->Html->link(__('New Group'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Groups') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('group_number') ?></th>
                    <th><?= $this->Paginator->sort('chit_amount') ?></th>
                    <th><?= $this->Paginator->sort('total_number') ?></th>
                    <th><?= $this->Paginator->sort('premium') ?></th>
                    <th><?= $this->Paginator->sort('gov_reg_no') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('no_of_months') ?></th>
                    <th><?= $this->Paginator->sort('created_date') ?></th>
                    <th><?= $this->Paginator->sort('modified_date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= $this->Number->format($group->id) ?></td>
                    <td><?= h($group->group_number) ?></td>
                    <td><?= $this->Number->format($group->chit_amount) ?></td>
                    <td><?= $this->Number->format($group->total_number) ?></td>
                    <td><?= $this->Number->format($group->premium) ?></td>
                    <td><?= h($group->gov_reg_no) ?></td>
                    <td><?= h($group->date) ?></td>
                    <td><?= $this->Number->format($group->status) ?></td>
                    <td><?= $this->Number->format($group->no_of_months) ?></td>
                    <td><?= h($group->created_date) ?></td>
                    <td><?= h($group->modified_date) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $group->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $group->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $group->id], ['confirm' => __('Are you sure you want to delete # {0}?', $group->id)]) ?>
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
