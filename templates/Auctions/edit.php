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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $auction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $auction->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Auctions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="auctions form content">
            <?= $this->Form->create($auction) ?>
            <fieldset>
                <legend><?= __('Edit Auction') ?></legend>
                <?php
                    echo $this->Form->control('group_id', ['options' => $groups]);
                    echo $this->Form->control('auction_no');
                    echo $this->Form->control('auction_date');
                    echo $this->Form->control('auction_highest_percent');
                    echo $this->Form->control('auction_winner_member');
                    echo $this->Form->control('chit_amount');
                    echo $this->Form->control('discount_amount');
                    echo $this->Form->control('priced_amount');
                    echo $this->Form->control('foreman_commission');
                    echo $this->Form->control('total_subscriber_dividend');
                    echo $this->Form->control('subscriber_dividend');
                    echo $this->Form->control('net_subscription_amount');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
