<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Groups Model
 *
 * @method \App\Model\Entity\Group newEmptyEntity()
 * @method \App\Model\Entity\Group newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Group[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Group get($primaryKey, $options = [])
 * @method \App\Model\Entity\Group findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Group patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Group[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Group|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Group saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class GroupsTable extends Table
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

        $this->setTable('groups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->hasMany('MembersGroups', [
            'foreignKey' => 'group_id',
        ]);
        $this->hasMany('Auctions', [
            'foreignKey' => 'group_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'created_by' 
        ]);
        $this->hasMany('PaymentVouchers', [
            'foreignKey' => 'group_id'
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
            ->decimal('chit_amount')
            ->requirePresence('chit_amount', 'create')
            ->notEmptyString('chit_amount');

        $validator
            ->integer('total_number')
            ->requirePresence('total_number', 'create')
            ->notEmptyString('total_number');

        $validator
            ->decimal('premium')
            ->requirePresence('premium', 'create')
            ->notEmptyString('premium');

        $validator
            ->scalar('gov_reg_no')
            ->maxLength('gov_reg_no', 500)
            ->requirePresence('gov_reg_no', 'create')
            ->notEmptyString('gov_reg_no');

        $validator
            ->scalar('date')
            ->requirePresence('date', 'create')
            ->notEmptyString('date');

        $validator
            ->integer('no_of_months')
            ->requirePresence('no_of_months', 'create')
            ->notEmptyString('no_of_months');

        $validator
            ->scalar('group_type') 
            ->requirePresence('group_type', 'create')
            ->notEmptyString('group_type');

        $validator
            ->scalar('auction_date') 
            ->requirePresence('auction_date', 'create')
            ->notEmptyString('auction_date');

        $validator
            ->decimal('late_fee')
            ->requirePresence('late_fee', 'create')
            ->notEmptyString('late_fee');
                
        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');
            
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
        $rules->add($rules->isUnique(['group_code']));

        return $rules;
    }

    //Function for ajax listing, filter, sort, search
    public function GetData($user_id) {
        $aColumns = array('g.group_code','g.chit_amount','g.total_number','g.premium','g.gov_reg_no','g.date','g.no_of_months','g.status' );
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "g.id";
        /* DB table to use */
        $sTable = "groups g";
       
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
                    $sOrder .= "".$aColumns[$_POST['order'][$i]['column']]." ".
                    ($_POST['order'][$i]['dir']==='asc' ? 'asc' : 'desc') .", ";
                }
            }
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }else{
            //default order 
            $sOrder = "ORDER BY g.id desc ";
        }
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $sWhere = " WHERE g.created_by= '".$user_id."' ";
        if ( isset($_POST['search']) && $_POST['search']['value'] != "" )
        {
            $sWhere .= " AND (";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    $sWhere .= "".$aColumns[$i]." LIKE '%".( $_POST['search']['value'] )."%' OR ";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))." , g.id as actions, count(a.group_id) as auctions_cnt
        FROM   $sTable  left join auctions a on g.id =a.group_id 
        $sWhere
        group by g.id
        $sOrder
        $sLimit
        ";
        // echo $sQuery;exit;
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
        return $output;
    }

    /***
    * Get group members list
    */
    public function getGroupMembersData($group_id) {
        $ucase_first_name = "CONCAT(UCASE(LEFT(u.first_name, 1)),SUBSTRING(u.first_name, 2)) "; 
        $ucase_middle_name = "CONCAT(UCASE(LEFT(u.middle_name, 1)),SUBSTRING(u.middle_name, 2)) "; 
        $ucase_last_name = "CONCAT(UCASE(LEFT(u.last_name, 1)),SUBSTRING(u.last_name, 2)) "; 
        // $aColumns = array('customer_id' , "concat(u.first_name,' ', u.middle_name,' ',u.last_name) as name", 'u.address','mg.ticket_no'); 
         $aColumns = array('customer_id' , "concat($ucase_first_name,' ', $ucase_middle_name,' ',$ucase_last_name) as name", 'u.address','mg.ticket_no'); 
// echo '<pre>';print_r($aColumns);exit;
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "u.id";
        /* DB table to use */
        $sTable = "users";
        $groupstb = "groups";
        $memberGroupsTb = "members_groups";

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
        $sWhere = "WHERE g.id = ".$group_id;
        if ( isset($_POST['search']) && $_POST['search']['value'] != "" )
        {
            $sWhere .= " AND (";

                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    //remove 'as' word if exist
                    $columns = preg_replace('/ as.*/', '', $aColumns[$i]);
                    $sWhere .= "".$columns." LIKE '%".( $_POST['search']['value'] )."%' OR ";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(' , ', ' ', implode(', ', $aColumns))."  , mg.id as action
        FROM   $sTable u  join $memberGroupsTb mg on u.id = mg.user_id  join $groupstb g on  g.id=mg.group_id
        $sWhere
        $sOrder
        $sLimit
        ";
        // echo $sQuery;
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
        FROM   $sTable u  join $memberGroupsTb mg on u.id = mg.user_id  join $groupstb g on  g.id=mg.group_id WHERE g.id = ".$group_id."
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
        return $output;
    }

    function get_group_code($total_number,$created_by,$chit_amount,$group_id){ 
        $conn = ConnectionManager::get('default');
        $stmt = $conn->execute("call CreateGroupCode($total_number,$created_by,$chit_amount,$group_id,@p3)");
        $stmt = $conn->execute("SELECT @p3 AS group_code");
        
        $result = $stmt ->fetchAll('assoc');
        // echo '<pre>';print_r($result);exit;
        return isset($result[0]['group_code']) ? $result[0]['group_code'] : '';
    }

    public function GetDashboardData($user_id) { 
        $aColumns = array('g.chit_amount','g.no_of_months','g.premium', 
                    "COUNT(a.id) as no_of_installments",
                    "SUM(a.net_subscription_amount) as total_amt_payable",
                    "SUM(a.subscriber_dividend) as total_dividend");
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "g.chit_amount";
        /* DB table to use */
        $sTable = "auctions a";
       
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
                    $sOrder .= "".$aColumns[$_POST['order'][$i]['column']]." ".
                    ($_POST['order'][$i]['dir']==='asc' ? 'asc' : 'desc') .", ";
                }
            }
            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
            }
        }else{
            //default order 
            $sOrder = "ORDER BY g.id desc ";
        }
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $sWhere = " WHERE g.created_by= '".$user_id."' ";
        $having='';
        if ( isset($_POST['search']) && $_POST['search']['value'] != "" )
        {
            $having="Having (no_of_installments ='".( $_POST['search']['value'] )."'  or total_amt_payable='".( $_POST['search']['value'] )."'  or total_dividend='".( $_POST['search']['value'] )."' )";
            $sWhere .= " OR (";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    $columns = preg_replace('/ as.*/', '', $aColumns[$i]);
                    if(in_array($columns, ['COUNT(a.id)','SUM(a.net_subscription_amount)','SUM(a.subscriber_dividend)'])){
                        continue;
                    }
                    // $sWhere .= "".$columns." LIKE '%".( $_POST['search']['value'] )."%' OR ";
                    $sWhere .= "".$columns." = '".( $_POST['search']['value'] )."' OR ";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))." 
        FROM   $sTable join groups g on g.id =a.group_id 
        $sWhere
        group by g.id
        $having
        $sOrder
        $sLimit
        ";
        // echo $sQuery;exit;
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
        $sQuery = "SELECT COUNT(*) as cnt from (
        SELECT COUNT(".$sIndexColumn.") as cnt
        FROM   $sTable join groups g on g.id =a.group_id where g.created_by = ".$user_id." group by g.id
        ) cnt ";
        $rResultTotal = $conn->execute($sQuery);
        $aResultTotal = $rResultTotal ->fetchAll('assoc');
         // echo '$aResultTotal <pre>';print_r($aResultTotal);exit;
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
        return $output;
    }
}
