<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Auction $auction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Auction'), ['action' => 'edit', $auction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Auction'), ['action' => 'delete', $auction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Auctions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Auction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="auctions view content">
            <h3><?= h($auction->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Group') ?></th>
                    <td><?= $auction->has('group') ? $this->Html->link($auction->group->id, ['controller' => 'Groups', 'action' => 'view', $auction->group->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($auction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Auction No') ?></th>
                    <td><?= $this->Number->format($auction->auction_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Auction Highest Percent') ?></th>
                    <td><?= $this->Number->format($auction->auction_highest_percent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Auction Winner Member') ?></th>
                    <td><?= $this->Number->format($auction->auction_winner_member) ?></td>
                </tr>
                <tr>
                    <th><?= __('Chit Amount') ?></th>
                    <td><?= $this->Number->format($auction->chit_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Amount') ?></th>
                    <td><?= $this->Number->format($auction->discount_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priced Amount') ?></th>
                    <td><?= $this->Number->format($auction->priced_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Foreman Commission') ?></th>
                    <td><?= $this->Number->format($auction->foreman_commission) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Subscriber Dividend') ?></th>
                    <td><?= $this->Number->format($auction->total_subscriber_dividend) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subscriber Dividend') ?></th>
                    <td><?= $this->Number->format($auction->subscriber_dividend) ?></td>
                </tr>
                <tr>
                    <th><?= __('Net Subscription Amount') ?></th>
                    <td><?= $this->Number->format($auction->net_subscription_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Auction Date') ?></th>
                    <td><?= h($auction->auction_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($auction->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($auction->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
