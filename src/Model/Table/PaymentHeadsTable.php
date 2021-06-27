<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PaymentHeads Model
 *
 * @property \App\Model\Table\OtherPaymentsTable&\Cake\ORM\Association\HasMany $OtherPayments
 *
 * @method \App\Model\Entity\PaymentHead newEmptyEntity()
 * @method \App\Model\Entity\PaymentHead newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PaymentHead[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PaymentHead get($primaryKey, $options = [])
 * @method \App\Model\Entity\PaymentHead findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PaymentHead patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PaymentHead[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PaymentHead|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PaymentHead saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PaymentHead[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PaymentHead[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PaymentHead[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PaymentHead[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentHeadsTable extends Table
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

        $this->setTable('payment_heads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('OtherPayments', [
            'foreignKey' => 'payment_head_id',
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
            ->scalar('payment_head')
            ->maxLength('payment_head', 500)
            ->requirePresence('payment_head', 'create')
            ->notEmptyString('payment_head');

        return $validator;
    }
}
