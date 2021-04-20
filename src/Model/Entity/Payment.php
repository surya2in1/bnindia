<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property string $receipt_no
 * @property \Cake\I18n\FrozenDate $due_date
 * @property \Cake\I18n\FrozenDate $date
 * @property int $group_id
 * @property string $subscriber_ticket_no
 * @property int $user_id
 * @property int $instalment_no
 * @property int $instalment_month
 * @property int $subscription_amount
 * @property int $late_fee
 * @property int $received_by
 * @property \Cake\I18n\FrozenDate $cash_received_date
 * @property string $cheque_no
 * @property \Cake\I18n\FrozenDate $cheque_date
 * @property int $cheque_bank_details
 * @property int $cheque_drown_on
 * @property \Cake\I18n\FrozenDate $direct_debit_date
 * @property string $direct_debit_transaction_no
 * @property string $remark
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\Member $member
 */
class Payment extends Entity
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
        'receipt_no' => true,
        'due_date' => true,
        'date' => true,
        'group_id' => true,
        'subscriber_ticket_no' => true,
        'user_id' => true,
        'instalment_no' => true,
        'instalment_month' => true,
        'subscription_amount' => true,
        'late_fee' => true,
        'received_by' => true,
        'cash_received_date' => true,
        'cheque_no' => true,
        'cheque_date' => true,
        'cheque_bank_details' => true,
        'cheque_drown_on' => true,
        'direct_debit_date' => true,
        'direct_debit_transaction_no' => true,
        'remark' => true,
        'auction_id' => true,
        'total_amount' => true,
        'pending_amount' => true,
        'is_installment_complete' => true,
        'created' => true,
        'modified' => true,
    ];
}
