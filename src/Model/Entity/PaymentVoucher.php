<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PaymentVoucher Entity
 *
 */
class PaymentVoucher extends Entity
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
          'date'=>true,
          'user_id'=>true,
          'group_id'=>true,
          'auction_id'=>true,
          'auction_date'=>true,
          'chit_amount'=>true,
          'foreman_commission'=>true,
          'total_subscriber_dividend'=>true,
          'gst'=>true,
          'total'=>true,
          'cheque_dd_no'=>true,
          'resaon' => true,
    ];
}
