<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('password') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('middle_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('state') ?></th>
                    <th><?= $this->Paginator->sort('gender') ?></th>
                    <th><?= $this->Paginator->sort('maritial_status') ?></th>
                    <th><?= $this->Paginator->sort('date_of_birth') ?></th>
                    <th><?= $this->Paginator->sort('mobile_number') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('nominee_name') ?></th>
                    <th><?= $this->Paginator->sort('nominee_relation') ?></th>
                    <th><?= $this->Paginator->sort('nominee_dob') ?></th>
                    <th><?= $this->Paginator->sort('occupation') ?></th>
                    <th><?= $this->Paginator->sort('income_amt') ?></th>
                    <th><?= $this->Paginator->sort('address_proof') ?></th>
                    <th><?= $this->Paginator->sort('photo_proof') ?></th>
                    <th><?= $this->Paginator->sort('other_document') ?></th>
                    <th><?= $this->Paginator->sort('profile_picture') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->username) ?></td>
                    <td><?= h($user->password) ?></td>
                    <td><?= h($user->first_name) ?></td>
                    <td><?= h($user->middle_name) ?></td>
                    <td><?= h($user->last_name) ?></td>
                    <td><?= h($user->address) ?></td>
                    <td><?= h($user->city) ?></td>
                    <td><?= h($user->state) ?></td>
                    <td><?= h($user->gender) ?></td>
                    <td><?= h($user->maritial_status) ?></td>
                    <td><?= h($user->date_of_birth) ?></td>
                    <td><?= h($user->mobile_number) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->nominee_name) ?></td>
                    <td><?= h($user->nominee_relation) ?></td>
                    <td><?= h($user->nominee_dob) ?></td>
                    <td><?= h($user->occupation) ?></td>
                    <td><?= h($user->income_amt) ?></td>
                    <td><?= h($user->address_proof) ?></td>
                    <td><?= h($user->photo_proof) ?></td>
                    <td><?= h($user->other_document) ?></td>
                    <td><?= h($user->profile_picture) ?></td>
                    <td><?= $this->Number->format($user->status) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
