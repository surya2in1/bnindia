<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OtherPayment Entity
 *
 * @property int $id
 * @property int $payment_head_id
 * @property \Cake\I18n\FrozenDate $date
 * @property int $user_id
 * @property string $total_amount
 * @property string $gst
 * @property string $less_tds
 * @property string $total_amount_paid_rs
 * @property string $cheque_transaction_no
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\PaymentHead $payment_head
 * @property \App\Model\Entity\User $user
 */
class OtherPayment extends Entity
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
        'other_payment_no' => true,
        'remark' => true,
        'payment_head_id' => true,
        'date' => true,
        'paid_to_name' => true,
        'total_amount' => true,
        'gst' => true,
        'less_tds' => true,
        'total_amount_paid_rs' => true,
        'cheque_transaction_no' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'payment_head' => true
    ];
}
