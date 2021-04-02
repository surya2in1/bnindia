<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Auction Entity
 *
 * @property int $id
 * @property int $group_id
 * @property int $auction_no
 * @property \Cake\I18n\FrozenDate $auction_date
 * @property string $auction_highest_percent
 * @property int $auction_winner_member
 * @property string $chit_amount
 * @property string $discount_amount
 * @property string $priced_amount
 * @property string $foreman_commission
 * @property string $total_subscriber_dividend
 * @property string $subscriber_dividend
 * @property string $net_subscription_amount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Group $group
 */
class Auction extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'group_id' => true,
        'auction_no' => true,
        'auction_date' => true,
        'auction_highest_percent' => true,
        'auction_winner_member' => true,
        'chit_amount' => true,
        'discount_amount' => true,
        'priced_amount' => true,
        'foreman_commission' => true,
        'total_subscriber_dividend' => true,
        'subscriber_dividend' => true,
        'net_subscription_amount' => true,
        'created' => true,
        'modified' => true,
        'group' => true,
        'is_all_auction_completed' => true
    ];
}
