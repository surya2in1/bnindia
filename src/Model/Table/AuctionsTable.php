<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Auctions Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\Auction newEmptyEntity()
 * @method \App\Model\Entity\Auction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Auction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Auction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Auction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Auction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Auction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Auction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Auction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Auction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Auction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Auction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Auction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AuctionsTable extends Table
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

        $this->setTable('auctions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER',
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
            ->integer('auction_no')
            ->requirePresence('auction_no', 'create')
            ->notEmptyString('auction_no');

        $validator
            ->date('auction_date')
            ->requirePresence('auction_date', 'create')
            ->notEmptyDate('auction_date');

        $validator
            ->decimal('auction_highest_percent')
            ->requirePresence('auction_highest_percent', 'create')
            ->notEmptyString('auction_highest_percent');

        $validator
            ->integer('auction_winner_member')
            ->requirePresence('auction_winner_member', 'create')
            ->notEmptyString('auction_winner_member');

        $validator
            ->decimal('chit_amount')
            ->requirePresence('chit_amount', 'create')
            ->notEmptyString('chit_amount');

        $validator
            ->decimal('discount_amount')
            ->requirePresence('discount_amount', 'create')
            ->notEmptyString('discount_amount');

        $validator
            ->decimal('priced_amount')
            ->requirePresence('priced_amount', 'create')
            ->notEmptyString('priced_amount');

        $validator
            ->decimal('foreman_commission')
            ->requirePresence('foreman_commission', 'create')
            ->notEmptyString('foreman_commission');

        $validator
            ->decimal('total_subscriber_dividend')
            ->requirePresence('total_subscriber_dividend', 'create')
            ->notEmptyString('total_subscriber_dividend');

        $validator
            ->decimal('subscriber_dividend')
            ->requirePresence('subscriber_dividend', 'create')
            ->notEmptyString('subscriber_dividend');

        $validator
            ->decimal('net_subscription_amount')
            ->requirePresence('net_subscription_amount', 'create')
            ->notEmptyString('net_subscription_amount');

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

        return $rules;
    }
}
