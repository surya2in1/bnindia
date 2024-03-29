<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MembersGroup Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $group_id
 * @property \Cake\I18n\FrozenTime $created_date
 * @property \Cake\I18n\FrozenTime $modified_date
 *
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Group $group
 */
class MembersGroup extends Entity
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
        'user_id' => true,
        'group_id' => true,
        'created_date' => true,
        'modified_date' => true,
        'member' => true,
        'group' => true,
        'is_transfer_user' => true,
        'old_user_id' => true,
        'new_user_id' => true,
        'removal_resaon' => true,
        'remark' => true,
        'date_of_removal' => true,
        'created_by'=>true
    ];
}
