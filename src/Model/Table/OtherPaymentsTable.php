<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\Datasource\ConnectionManager;
use Cake\Database\Type;

/**
 * OtherPayments Model
 *
 * @property \App\Model\Table\PaymentHeadsTable&\Cake\ORM\Association\BelongsTo $PaymentHeads
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\OtherPayment newEmptyEntity()
 * @method \App\Model\Entity\OtherPayment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\OtherPayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OtherPayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\OtherPayment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\OtherPayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OtherPayment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\OtherPayment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OtherPayment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OtherPayment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OtherPayment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\OtherPayment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\OtherPayment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OtherPaymentsTable extends Table
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

        $this->setTable('other_payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PaymentHeads', [
            'foreignKey' => 'payment_head_id',
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->decimal('total_amount')
            ->requirePresence('total_amount', 'create')
            ->notEmptyString('total_amount');

        $validator
            ->decimal('gst')
            ->requirePresence('gst', 'create')
            ->notEmptyString('gst');

        $validator
            ->decimal('less_tds')
            ->requirePresence('less_tds', 'create')
            ->notEmptyString('less_tds');

        $validator
            ->decimal('total_amount_paid_rs')
            ->requirePresence('total_amount_paid_rs', 'create')
            ->notEmptyString('total_amount_paid_rs');

        $validator
            ->scalar('cheque_transaction_no')
            ->maxLength('cheque_transaction_no', 500)
            ->requirePresence('cheque_transaction_no', 'create')
            ->notEmptyString('cheque_transaction_no');

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
        $rules->add($rules->existsIn(['payment_head_id'], 'PaymentHeads')); 

        return $rules;
    }
    
    //Function for ajax listing, filter, sort, search
    public function GetData($user_id) {
         $aColumns = array(
            'ph.payment_head', 
            "DATE_FORMAT(p.date,'%m/%d/%Y') as date",
            "p.paid_to_name",
            'p.total_amount',
            'p.gst',
            'p.less_tds', 
            'p.total_amount_paid_rs',
            'p.cheque_transaction_no', 
        );
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "p.id";
        /* DB table to use */
        $sTable = "other_payments p";
       
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
                $sOrder = " ";
            }
        }else{
             $sOrder = " ORDER BY p.id desc";
        }
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $sWhere = " WHERE p.created_by= '".$user_id."' ";
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
        FROM   $sTable join payment_heads ph on ph.id = p.payment_head_id 
        $sWhere
        $sOrder
        $sLimit
        ";
        //echo  $sQuery;exit;
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
}
