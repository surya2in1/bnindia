<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Agents Model
 *
 * @method \App\Model\Entity\Agent newEmptyEntity()
 * @method \App\Model\Entity\Agent newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Agent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Agent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Agent findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Agent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Agent[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Agent|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Agent saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Agent[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AgentsTable extends Table
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

        $this->setTable('agents');
        $this->setDisplayField('name');
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
            ->scalar('agent_code')
            ->maxLength('agent_code', 50)
            ->requirePresence('agent_code', 'create')
            ->notEmptyString('agent_code');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('address')
            ->maxLength('address', 500)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        $validator
            ->scalar('mobile_number')
            ->maxLength('mobile_number', 11)
            ->requirePresence('mobile_number', 'create')
            ->notEmptyString('mobile_number');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('address_proof')
            ->maxLength('address_proof', 500)
            ->requirePresence('address_proof', 'create')
            ->notEmptyString('address_proof');

        $validator
            ->scalar('pan_card')
            ->maxLength('pan_card', 500)
            ->requirePresence('pan_card', 'create')
            ->notEmptyString('pan_card');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 500)
            ->requirePresence('photo', 'create')
            ->notEmptyString('photo');

        $validator
            ->scalar('educational_proof')
            ->maxLength('educational_proof', 500)
            ->requirePresence('educational_proof', 'create')
            ->notEmptyString('educational_proof');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 500)
            ->requirePresence('bank_name', 'create')
            ->notEmptyString('bank_name');

        $validator
            ->scalar('account_no')
            ->maxLength('account_no', 13)
            ->requirePresence('account_no', 'create')
            ->notEmptyString('account_no');

        $validator
            ->scalar('ifsc_code')
            ->maxLength('ifsc_code', 100)
            ->requirePresence('ifsc_code', 'create')
            ->notEmptyString('ifsc_code');

        $validator
            ->scalar('branch_name')
            ->maxLength('branch_name', 100)
            ->requirePresence('branch_name', 'create')
            ->notEmptyString('branch_name');

        $validator
            ->scalar('bank_address')
            ->maxLength('bank_address', 100)
            ->requirePresence('bank_address', 'create')
            ->notEmptyString('bank_address');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        return $validator;
    }
}
