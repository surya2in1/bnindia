<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Auction[]|\Cake\Collection\CollectionInterface $auctions
 */
?>
<div class="auctions index content">
    <?= $this->Html->link(__('New Auction'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Auctions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('group_id') ?></th>
                    <th><?= $this->Paginator->sort('auction_no') ?></th>
                    <th><?= $this->Paginator->sort('auction_date') ?></th>
                    <th><?= $this->Paginator->sort('auction_highest_percent') ?></th>
                    <th><?= $this->Paginator->sort('auction_winner_member') ?></th>
                    <th><?= $this->Paginator->sort('chit_amount') ?></th>
                    <th><?= $this->Paginator->sort('discount_amount') ?></th>
                    <th><?= $this->Paginator->sort('priced_amount') ?></th>
                    <th><?= $this->Paginator->sort('foreman_commission') ?></th>
                    <th><?= $this->Paginator->sort('total_subscriber_dividend') ?></th>
                    <th><?= $this->Paginator->sort('subscriber_dividend') ?></th>
                    <th><?= $this->Paginator->sort('net_subscription_amount') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auctions as $auction): ?>
                <tr>
                    <td><?= $this->Number->format($auction->id) ?></td>
                    <td><?= $auction->has('group') ? $this->Html->link($auction->group->id, ['controller' => 'Groups', 'action' => 'view', $auction->group->id]) : '' ?></td>
                    <td><?= $this->Number->format($auction->auction_no) ?></td>
                    <td><?= h($auction->auction_date) ?></td>
                    <td><?= $this->Number->format($auction->auction_highest_percent) ?></td>
                    <td><?= $this->Number->format($auction->auction_winner_member) ?></td>
                    <td><?= $this->Number->format($auction->chit_amount) ?></td>
                    <td><?= $this->Number->format($auction->discount_amount) ?></td>
                    <td><?= $this->Number->format($auction->priced_amount) ?></td>
                    <td><?= $this->Number->format($auction->foreman_commission) ?></td>
                    <td><?= $this->Number->format($auction->total_subscriber_dividend) ?></td>
                    <td><?= $this->Number->format($auction->subscriber_dividend) ?></td>
                    <td><?= $this->Number->format($auction->net_subscription_amount) ?></td>
                    <td><?= h($auction->created) ?></td>
                    <td><?= h($auction->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $auction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $auction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $auction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auction->id)]) ?>
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
