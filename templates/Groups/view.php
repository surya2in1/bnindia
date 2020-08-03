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
            <?= $this->Html->link(__('Edit Group'), ['action' => 'edit', $group->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Group'), ['action' => 'delete', $group->id], ['confirm' => __('Are you sure you want to delete # {0}?', $group->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Group'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="groups view content">
            <h3><?= h($group->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Group Number') ?></th>
                    <td><?= h($group->group_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Gov Reg No') ?></th>
                    <td><?= h($group->gov_reg_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($group->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chit Amount') ?></th>
                    <td><?= $this->Number->format($group->chit_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Number') ?></th>
                    <td><?= $this->Number->format($group->total_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Premium') ?></th>
                    <td><?= $this->Number->format($group->premium) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($group->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Of Months') ?></th>
                    <td><?= $this->Number->format($group->no_of_months) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($group->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created Date') ?></th>
                    <td><?= h($group->created_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified Date') ?></th>
                    <td><?= h($group->modified_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
