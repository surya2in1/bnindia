<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Group Entity
 *
 * @property int $id
 * @property string $group_number
 * @property int $chit_amount
 * @property int $total_number
 * @property int $premium
 * @property string $gov_reg_no
 * @property \Cake\I18n\FrozenDate $date
 * @property int $status
 * @property int $no_of_months
 * @property \Cake\I18n\FrozenTime $created_date
 * @property \Cake\I18n\FrozenTime $modified_date
 */
class Group extends Entity
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
        'group_code' =>true,
        'chit_amount' => true,
        'total_number' => true,
        'premium' => true,
        'gov_reg_no' => true,
        'date' => true,
        'status' => true,
        'no_of_months' => true,
        'created_date' => true,
        'modified_date' => true,
        'group_type' => true,
        'auction_day' => true,
        'late_fee'=> true,
        'created_by' => true
    ];
}
