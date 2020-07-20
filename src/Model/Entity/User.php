<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $password
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $gender
 * @property string $maritial_status
 * @property \Cake\I18n\FrozenDate $date_of_birth
 * @property string $mobile_number
 * @property string $email
 * @property string|null $nominee_name
 * @property string|null $nominee_relation
 * @property \Cake\I18n\FrozenDate|null $nominee_dob
 * @property string|null $accupation
 * @property string|null $income_amt
 * @property string|null $address_proof
 * @property string|null $photo_proof
 * @property string|null $other_document
 * @property string|null $profile_picture
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class User extends Entity
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
        'password' => true,
        'first_name' => true,
        'middle_name' => true,
        'last_name' => true,
        'address' => true,
        'city' => true,
        'state' => true,
        'gender' => true,
        'maritial_status' => true,
        'date_of_birth' => true,
        'mobile_number' => true,
        'email' => true,
        'nominee_name' => true,
        'nominee_relation' => true,
        'nominee_dob' => true,
        'accupation' => true,
        'income_amt' => true,
        'address_proof' => true,
        'photo_proof' => true,
        'other_document' => true,
        'profile_picture' => true,
        'status' => true,
        'role_id' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
          return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
