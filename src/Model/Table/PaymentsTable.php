<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payments Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\MembersTable&\Cake\ORM\Association\BelongsTo $Members
 *
 * @method \App\Model\Entity\Payment newEmptyEntity()
 * @method \App\Model\Entity\Payment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Payment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Payment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentsTable extends Table
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

        $this->setTable('payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Auctions', [
            'foreignKey' => 'auction_id' 
        ]);
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
            ->scalar('receipt_no')
            ->maxLength('receipt_no', 500)
            ->requirePresence('receipt_no', 'create')
            ->notEmptyString('receipt_no');

        $validator
            ->date('due_date')
            ->requirePresence('due_date', 'create')
            ->notEmptyDate('due_date');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('subscriber_ticket_no')
            ->maxLength('subscriber_ticket_no', 500)
            ->requirePresence('subscriber_ticket_no', 'create')
            ->notEmptyString('subscriber_ticket_no');

        $validator
            ->integer('instalment_no')
            ->requirePresence('instalment_no', 'create')
            ->notEmptyString('instalment_no');

        $validator
            ->scalar('instalment_month')
            ->requirePresence('instalment_month', 'create')
            ->notEmptyString('instalment_month');

        $validator
            ->decimal('subscription_amount')
            ->requirePresence('subscription_amount', 'create')
            ->notEmptyString('subscription_amount');

        $validator
            ->decimal('late_fee')
            ->requirePresence('late_fee', 'create')
            ->notEmptyString('late_fee');

        $validator
            ->requirePresence('received_by', 'create')
            ->notEmptyString('received_by');

        // $validator
        //     ->date('cash_received_date')
        //     ->requirePresence('cash_received_date', 'create')
        //     ->notEmptyDate('cash_received_date');

        // $validator
        //     ->scalar('cheque_no')
        //     ->maxLength('cheque_no', 500)
        //     ->requirePresence('cheque_no', 'create')
        //     ->notEmptyString('cheque_no');

        // $validator
        //     ->date('cheque_date')
        //     ->requirePresence('cheque_date', 'create')
        //     ->notEmptyDate('cheque_date');

        // $validator
        //     ->integer('cheque_bank_details')
        //     ->requirePresence('cheque_bank_details', 'create')
        //     ->notEmptyString('cheque_bank_details');

        // $validator
        //     ->integer('cheque_drown_on')
        //     ->requirePresence('cheque_drown_on', 'create')
        //     ->notEmptyString('cheque_drown_on');

        // $validator
        //     ->date('direct_debit_date')
        //     ->requirePresence('direct_debit_date', 'create')
        //     ->notEmptyDate('direct_debit_date');

        // $validator
        //     ->scalar('direct_debit_transaction_no')
        //     ->maxLength('direct_debit_transaction_no', 500)
        //     ->requirePresence('direct_debit_transaction_no', 'create')
        //     ->notEmptyString('direct_debit_transaction_no');

        $validator
            ->scalar('remark')
            ->maxLength('remark', 500)
            ->requirePresence('remark', 'create')
            ->notEmptyString('remark');

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
        $rules->add($rules->existsIn(['group_id'], 'Groups'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
