<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Agent Entity
 *
 * @property int $id
 * @property string $agent_code
 * @property string $name
 * @property string $address
 * @property string $mobile_number
 * @property string $email
 * @property string $address_proof
 * @property string $pan_card
 * @property string $photo
 * @property string $educational_proof
 * @property string $bank_name
 * @property string $account_no
 * @property string $ifsc_code
 * @property string $branch_name
 * @property string $bank_address
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Agent extends Entity
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
        'agent_code' => true,
        'name' => true,
        'address' => true,
        'mobile_number' => true,
        'email' => true,
        'address_proof' => true,
        'pan_card' => true,
        'photo' => true,
        'educational_proof' => true,
        'bank_name' => true,
        'account_no' => true,
        'ifsc_code' => true,
        'branch_name' => true,
        'bank_address' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
    ];
}
