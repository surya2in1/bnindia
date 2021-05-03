<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

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

    public function validationReceivedby(Validator $validator)
    {
        $validator = $this->validationDefault($validator);
      
        $validator->allowEmptyString('cheque_no',null, function ($context) {
            return $context['data']['received_by'] === '';
        });

        $validator->allowEmptyDate('cheque_date',null, function ($context) {
            return $context['data']['received_by'] === '';
        });

        $validator->allowEmptyString('cheque_bank_details',null, function ($context) {
            return $context['data']['received_by'] === '';
        });

        $validator->allowEmptyString('cheque_drown_on',null, function ($context) {
            return $context['data']['received_by'] === '';
        });

        $validator->allowEmptyDate('direct_debit_date',null, function ($context) {
            return $context['data']['received_by'] === '';
        });

        $validator->allowEmptyString('direct_debit_transaction_no',null, function ($context) {
            return $context['data']['received_by'] === '';
        });

        // $validator->add('creditcard_number', 'cc', [
        //     'rule' => 'cc',
        //     'message' => 'Please enter valid Credit Card',
        //     'on' => function ($context) {
        //         return $context['data']['received_by'] === 'credit_card';
        //     }
        // ]);

        //for cheque
        $validator->notEmptyString('cheque_no', 'Cheque No is required', function ($context) {
            return $context['data']['received_by'] === 2;
        });

        $validator->add('cheque_no', 'length', 
                        [
                            'rule' => ['maxLength', 500],
                            'on' => function ($context) {
                                return ($context['data']['received_by'] === 2);
                            }
                        ]);
        $validator->notEmptyDate('cheque_date', 'Cheque Date is required', function ($context) {
            return $context['data']['received_by'] === 2;
        }); 
        $validator->notEmptyString('cheque_bank_details', 'Cheque Bank Details is required', function ($context) {
            return $context['data']['received_by'] === 2;
        });
        $validator->notEmptyString('cheque_drown_on', 'Cheque Drown On is required', function ($context) {
            return $context['data']['received_by'] === 2;
        });

        //for Direct debit
        $validator->notEmptyDate('direct_debit_date', 'Direct Debit Date is required', function ($context) {
            return $context['data']['received_by'] === 3;
        }); 
        $validator->notEmptyString('direct_debit_transaction_no', 'Direct Debit Transaction No. is required', function ($context) {
            return $context['data']['received_by'] === 3;
        });

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

    //Function for ajax listing, filter, sort, search
    public function GetData() {
        $aColumns = array( 'p.receipt_no','g.group_code',"concat(u.first_name,' ', u.middle_name,' ',u.last_name) as member",'p.subscription_amount','p.late_fee','p.total_amount',"(
            CASE 
                WHEN received_by =1 THEN 'Cash'
                WHEN received_by =2 THEN 'Cheque'
                WHEN received_by =3 THEN 'Direct Debit' 
                ELSE '--'
            END) as received_by");
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "p.receipt_no";
        /* DB table to use */
        $sTable = "payments p";
       
        /*
        * MySQL connection
        */
        $conn = ConnectionManager::get('default');

       /*
        * Paging
        */
        $sLimit = "";
        if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $_POST['start'] ).", ".
            intval( $_POST['length'] );
        }
        /*
        * Ordering
        */
        $sOrder = "";
        if ( isset( $_POST['order'][0] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_POST['order'] ) ; $i++ )
            {
                if ( $_POST['columns'][$_POST['order'][$i]['column']]['orderable'] == "true" )
                {
                     //remove 'as' word if exist
                    $ordercolumns = preg_replace('/ as.*/', '', $aColumns[$_POST['order'][$i]['column']]);
                    $sOrder .= "".$ordercolumns." ".
                    ($_POST['order'][$i]['dir']==='asc' ? 'asc' : 'desc') .", ";
                }
            }
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $sWhere = "";
        if ( isset($_POST['search']) && $_POST['search']['value'] != "" )
        {
            $sWhere .= " WHERE (";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    //remove 'as' word if exist
                    $columns = preg_replace('/ as.*/', '', $aColumns[$i]); 
                    $sWhere .= "".$columns." LIKE '%".( $_POST['search']['value'] )."%' OR ";
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ')';
        }
        /* Individual column filtering */
        /*
        * SQL queries
        * Get data to display
        */
        $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns)).", p.id as action
        FROM   $sTable join groups g on g.id = p.group_id join users u on u.id = p.user_id
        $sWhere
        $sOrder
        $sLimit
        ";
        // echo  $sQuery;exit;
        $stmt = $conn->execute($sQuery);
        $rResult = $stmt ->fetchAll('assoc');
       
        /* Data set length after filtering */
        $sQuery = "
        SELECT FOUND_ROWS() as cnt
        ";
        $rResultFilterTotal = $conn->execute($sQuery);
        $aResultFilterTotal = $rResultFilterTotal ->fetchAll('assoc');
        $iFilteredTotal = $aResultFilterTotal[0]['cnt'];
        /* Total data set length */
        $sQuery = "
        SELECT COUNT(".$sIndexColumn.") as cnt
        FROM   $sTable
        ";
        $rResultTotal = $conn->execute($sQuery);
        $aResultTotal = $rResultTotal ->fetchAll('assoc');
        $iTotal = $aResultTotal[0]['cnt'];
        /*
        * Output
        */
        $output = array(
        "draw" => intval($_POST['draw']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" =>  $rResult
        );
         // echo '<pre>';print_r($output);exit;
        return $output;
    }

    //get pending payments 
     public function getDuePayments($group_id=0,$member_id=0) {
        $aColumns = [ 
            'Auctions.auction_no',
            "MONTHNAME(Auctions.auction_date) as instalment_month",
            'Auctions.net_subscription_amount',
            " @due_amount :=( CASE WHEN p.pending_amount > 0 THEN p.pending_amount ELSE Auctions.net_subscription_amount END) as due_amount",
            " @due_late_fee :=CalculateLateFee(Auctions.net_subscription_amount,g.late_fee,CreateDateFromDay(g.date,Auctions.auction_date)) as due_late_fee" ,
            "(@due_amount + @due_late_fee) as total_amount"
        ]; 

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "Auctions.auction_no";
        /* DB table to use */
        $sTable = "auctions"; 

        /*
        * MySQL connection
        */
        $conn = ConnectionManager::get('default');

       /*
        * Paging
        */
        $sLimit = "";
        if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $_POST['start'] ).", ".
            intval( $_POST['length'] );
        }
        /*
        * Ordering
        */ 
        $sOrder = "";
        if ( isset( $_POST['order'][0] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_POST['order'] ) ; $i++ )
            {
                if ( $_POST['columns'][$_POST['order'][$i]['column']]['orderable'] == "true" )
                {
                    //remove 'as' word if exist
                    $ordercolumns = preg_replace('/ as.*/', '', $aColumns[$_POST['order'][$i]['column']]);
                    $sOrder .= "".$ordercolumns." ".
                    ($_POST['order'][$i]['dir']==='asc' ? 'asc' : 'desc') .", ";
                }
            }
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $sWhere = "WHERE Auctions.group_id = ".$group_id;
        if ( isset($_POST['search']) && $_POST['search']['value'] != "" )
        {
            $sWhere .= " AND (";

                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    //remove 'as' word if exist
                    $columns = preg_replace('/ as.*/', '', $aColumns[$i]);
                    if($i ==1){
                        $sWhere .= "".$columns." LIKE '%".( $_POST['search']['value'] )."%' OR ";
                    }else{
                        $sWhere .= "".$columns." = ".( $_POST['search']['value'] )." OR ";
                    }
                }
                //remove last 3 words as 'OR'
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ')';
        }

        /* Individual column filtering */
        /*
        * SQL queries
        * Get data to display
        */
        $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS MAX(p.id) as pid, ".str_replace(' , ', ' ', implode(', ', $aColumns))." 
        FROM   $sTable Auctions
            LEFT JOIN payments p ON p.auction_id=Auctions.id 
            LEFT JOIN groups g on Auctions.group_id = g.id
        $sWhere
        GROUP BY Auctions.auction_no
        HAVING pid NOT IN (SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = ".$member_id." and group_id = ".$group_id." 
    and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id ASC) or pid is null 
        $sOrder
        $sLimit
        ";
        // echo $sQuery;exit;
        $modifiedQuery =str_replace('SQL_CALC_FOUND_ROWS',' ',$sQuery);
        $modifiedQuery =   substr($modifiedQuery, 0, strpos($modifiedQuery, "LIMIT"));
        $get_total_query = "SELECT SUM(total_amount) total_amount from (".$modifiedQuery.") t";
        
        $get_totalst = $conn->execute($get_total_query);
        $get_totalResult = $get_totalst ->fetch('assoc');
        // echo $get_total_query.'<pre>'; print_r($get_totalResult);exit;

        $stmt = $conn->execute($sQuery);
        $rResult = $stmt ->fetchAll('assoc');
       // echo '<pre>';print_r($rResult);exit;

        /* Data set length after filtering */
        $sQuery = "
        SELECT FOUND_ROWS() as cnt
        ";
        $rResultFilterTotal = $conn->execute($sQuery);
        $aResultFilterTotal = $rResultFilterTotal ->fetchAll('assoc');
        $iFilteredTotal = $aResultFilterTotal[0]['cnt'];
        /* Total data set length */
        $sQuery = "
        SELECT MAX(p.id) as pid
        FROM   $sTable Auctions
            LEFT JOIN payments p ON p.auction_id=Auctions.id 
            LEFT JOIN groups g on Auctions.group_id = g.id
        WHERE Auctions.group_id = ".$group_id."
        GROUP BY Auctions.auction_no
        HAVING pid NOT IN (SELECT IFNULL(MAX(id), 0) AS mId FROM payments where user_id = ".$member_id." and group_id = ".$group_id." 
    and is_installment_complete = 1 GROUP BY group_id,user_id,auction_id ASC) or pid is null ";
        $rResultTotal = $conn->execute($sQuery);
        $aResultTotal = $rResultTotal ->fetchAll('assoc');
        // echo '$aResultTotal<pre>';print_r($aResultTotal);exit;
        $iTotal = count($aResultTotal);
        /*
        * Output
        */
        $output = array(
        "draw" => intval($_POST['draw']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" =>  $rResult,
        "total_due_amount" => isset($get_totalResult['total_amount']) && ($get_totalResult['total_amount'] > 0) ? $get_totalResult['total_amount'] : '0.00'
        );
        return $output;
    }
}
