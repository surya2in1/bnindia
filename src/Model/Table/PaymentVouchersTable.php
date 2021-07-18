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
 * PaymentVouchersTable Model
 *
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaymentVouchersTable extends Table
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

        $this->setTable('payment_vouchers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->integer('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id');

        $validator
            ->decimal('group_id')
            ->requirePresence('group_id', 'create')
            ->notEmptyString('group_id');

        $validator
            ->integer('auction_id')
            ->requirePresence('auction_id', 'create')
            ->notEmptyString('auction_id');

        $validator
            ->date('auction_date')
            ->requirePresence('auction_date', 'create')
            ->notEmptyDate('auction_date');
            
        $validator
            ->decimal('chit_amount')
            ->requirePresence('chit_amount', 'create')
            ->notEmptyString('chit_amount');

        $validator
            ->decimal('foreman_commission')
            ->requirePresence('foreman_commission', 'create')
            ->notEmptyString('foreman_commission');

        $validator
            ->decimal('total_subscriber_dividend')
            ->requirePresence('total_subscriber_dividend', 'create')
            ->notEmptyString('total_subscriber_dividend');
            
        $validator
            ->decimal('gst')
            ->requirePresence('gst', 'create')
            ->notEmptyString('gst');
            
        $validator
            ->decimal('total')
            ->requirePresence('total', 'create')
            ->notEmptyString('total');
            
        $validator
            ->decimal('cheque_dd_no')
            ->requirePresence('cheque_dd_no', 'create')
            ->notEmptyString('cheque_dd_no');    
 
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['group_id'], 'Groups'));
        $rules->add($rules->existsIn(['auction_id'], 'Auctions'));

        return $rules;
    }
    
    //Function for ajax listing, filter, sort, search
    public function GetData($user_id) {
        $ucase_first_name = "CONCAT(UCASE(LEFT(u.first_name, 1)),SUBSTRING(u.first_name, 2)) "; 
        $ucase_middle_name = "CONCAT(UCASE(LEFT(u.middle_name, 1)),SUBSTRING(u.middle_name, 2)) "; 
        $ucase_last_name = "CONCAT(UCASE(LEFT(u.last_name, 1)),SUBSTRING(u.last_name, 2)) "; 
        
        $aColumns = array("DATE_FORMAT(p.date,'%m/%d/%Y') as date",
            "concat($ucase_first_name,' ', $ucase_middle_name,' ',$ucase_last_name) as member",
            'p.resaon',
            'g.group_code',
            'a.auction_no', 
            'p.total',
            'p.gst',
            'p.total_subscriber_dividend',
            'p.cheque_dd_no'
        );
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "p.id";
        /* DB table to use */
        $sTable = "payment_vouchers p";
       
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
        FROM   $sTable join groups g on g.id = p.group_id join users u on u.id = p.user_id left join auctions a on a.id=p.auction_id
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
