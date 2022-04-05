<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agent[]|\Cake\Collection\CollectionInterface $agents
 */
?>
<div class="agents index content">
    <?= $this->Html->link(__('New Agent'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Agents') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('agent_code') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('mobile_number') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('address_proof') ?></th>
                    <th><?= $this->Paginator->sort('pan_card') ?></th>
                    <th><?= $this->Paginator->sort('photo') ?></th>
                    <th><?= $this->Paginator->sort('educational_proof') ?></th>
                    <th><?= $this->Paginator->sort('bank_name') ?></th>
                    <th><?= $this->Paginator->sort('account_no') ?></th>
                    <th><?= $this->Paginator->sort('ifsc_code') ?></th>
                    <th><?= $this->Paginator->sort('branch_name') ?></th>
                    <th><?= $this->Paginator->sort('bank_address') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agents as $agent): ?>
                <tr>
                    <td><?= $this->Number->format($agent->id) ?></td>
                    <td><?= h($agent->agent_code) ?></td>
                    <td><?= h($agent->name) ?></td>
                    <td><?= h($agent->address) ?></td>
                    <td><?= h($agent->mobile_number) ?></td>
                    <td><?= h($agent->email) ?></td>
                    <td><?= h($agent->address_proof) ?></td>
                    <td><?= h($agent->pan_card) ?></td>
                    <td><?= h($agent->photo) ?></td>
                    <td><?= h($agent->educational_proof) ?></td>
                    <td><?= h($agent->bank_name) ?></td>
                    <td><?= h($agent->account_no) ?></td>
                    <td><?= h($agent->ifsc_code) ?></td>
                    <td><?= h($agent->branch_name) ?></td>
                    <td><?= h($agent->bank_address) ?></td>
                    <td><?= $this->Number->format($agent->created_by) ?></td>
                    <td><?= h($agent->created) ?></td>
                    <td><?= h($agent->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $agent->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $agent->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $agent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agent->id)]) ?>
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
