<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 200)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('middle_name')
            ->maxLength('middle_name', 100)
            ->requirePresence('middle_name', 'create');
            // ->notEmptyString('middle_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 100)
            ->requirePresence('last_name', 'create');
            // ->notEmptyString('last_name');

        $validator
            ->scalar('address')
            ->maxLength('address', 300)
            // ->requirePresence('address', 'create')
            ->allowEmptyString('address');

        $validator
            ->scalar('city')
            ->maxLength('city', 50)
            // ->requirePresence('city', 'create')
            ->allowEmptyString('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 50)
            // ->requirePresence('state', 'create')
            ->allowEmptyString('state');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 15)
            // ->requirePresence('gender', 'create')
            ->notEmptyString('gender');

        $validator
            ->scalar('maritial_status')
            ->maxLength('maritial_status', 30)
            // ->requirePresence('maritial_status', 'create')
            ->notEmptyString('maritial_status');

        $validator
            ->date('date_of_birth')
            // ->requirePresence('date_of_birth', 'create')
            ->allowEmptyString('date_of_birth');

        $validator
            ->scalar('mobile_number')
            ->maxLength('mobile_number', 10)
            // ->requirePresence('mobile_number', 'create')
            ->allowEmptyString('mobile_number');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('nominee_name')
            ->maxLength('nominee_name', 50)
            ->allowEmptyString('nominee_name');

        $validator
            ->scalar('nominee_relation')
            ->maxLength('nominee_relation', 50)
            ->allowEmptyString('nominee_relation');

        $validator
            ->date('nominee_dob')
            ->allowEmptyDate('nominee_dob');

        $validator
            ->scalar('accupation')
            ->maxLength('accupation', 50)
            ->allowEmptyString('accupation');

        $validator
            ->scalar('income_amt')
            ->maxLength('income_amt', 15)
            ->allowEmptyString('income_amt');

        $validator
            ->scalar('address_proof')
            ->maxLength('address_proof', 50)
            ->allowEmptyString('address_proof');

        $validator
            ->scalar('photo_proof')
            ->maxLength('photo_proof', 50)
            ->allowEmptyString('photo_proof');

        $validator
            ->scalar('other_document')
            ->maxLength('other_document', 50)
            ->allowEmptyString('other_document');

        $validator
            // ->scalar('profile_picture')
            // ->maxLength('profile_picture', 50)
            ->allowEmptyFile('profile_picture');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
