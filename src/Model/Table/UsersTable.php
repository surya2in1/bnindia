<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
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

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('MembersGroups', [
            'foreignKey' => 'user_id', 
             'joinType' => 'INNER',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'user_id', 
             'joinType' => 'INNER',
        ]);
        $this->hasMany('PaymentVouchers', [
            'foreignKey' => 'user_id', 
             'joinType' => 'INNER',
        ]);
        
        $this->belongsTo('Agents', [
            'foreignKey' => 'agent_id', 
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
            ->scalar('occupation')
            ->maxLength('occupation', 50)
            ->allowEmptyString('occupation');

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
            ->scalar('area_code')
            ->allowEmptyString('area_code');

        $validator
            ->integer('pin_code')
            ->allowEmptyString('pin_code');

        $validator
            ->integer('status')
            ->allowEmptyString('status');
            
        $validator
            ->scalar('branch_name')
            ->maxLength('branch_name', 200);    

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    public function GetData($user_id) { 
        $aColumns = array('u.customer_id', 'u.email','u.first_name','u.last_name','u.gender','u.status' );
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "u.id";
        /* DB table to use */
        $sTable = "users u";
       
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
        }
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $config_role_member = Configure::read('ROLE_MEMBER'); 
        $sWhere = "WHERE r.name = '".$config_role_member."' and u.created_by= '".$user_id."' ";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))." ,u.id as actions
        FROM   $sTable  left JOIN roles r on u.role_id = r.id 
        $sWhere
        $sOrder
        $sLimit
        ";
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
        FROM   $sTable left JOIN roles r on u.role_id = r.id 
        where r.name= '".$config_role_member."'
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

    public function getVaccantUsers($user_id) {  
        $aColumns = [
                    "concat(g.group_code,'-',mg.ticket_no) as gr_code_ticket",
                    'g.chit_amount','g.no_of_months','g.premium','mg.ticket_no'
                     ,"CONCAT_WS(' ',IF(u.first_name = '', NULL, u.first_name),IF(u.middle_name = '', NULL, u.middle_name),IF(u.last_name = '', NULL, u.last_name)) as member",
                     "(SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id) as no_of_installments",
                    "(SELECT SUM(net_subscription_amount) FROM auctions WHERE group_id = mg.group_id) as total_amt_payable",
                    "(SELECT SUM(subscriber_dividend) FROM auctions WHERE group_id = mg.group_id) as total_dividend" 
                ];
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "g.id";
        /* DB table to use */
        $sTable = "members_groups mg";
       
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
        $sOrder = " mg.group_id ASC, mg.user_id ASC ";
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
        $sWhere = "WHERE mg.group_id  IN (SELECT group_id  FROM auctions 
         WHERE auction_group_due_date <  CURRENT_DATE() GROUP BY group_id  ORDER BY group_id ASC) AND g.created_by= '".$user_id."' AND (mg.is_transfer_user =0 and mg.new_user_id=0) ";
        if ( isset($_POST['search']) && $_POST['search']['value'] != "" )
        {
            $sWhere .= " AND (";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))." ,u.id as actions,
        (SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id AND auction_winner_member =mg.user_id) as auction_winner,
        mg.group_id,mg.user_id,Pending_Installments(mg.group_id,mg.user_id) as pi

        FROM   $sTable 
        INNER JOIN groups g ON g.id = mg.group_id 
        INNER JOIN users u ON mg.user_id = u.id 
 
        $sWhere
        HAVING (pi >= 3 AND auction_winner = 0)
        $sOrder
        $sLimit
        ";
        // echo $sQuery;exit;
        $stmt = $conn->execute($sQuery); 
        $rResult = $stmt ->fetchAll('assoc');
        /* Data set length after filtering */
        // echo $sQuery;exit;
        $sQuery = "
        SELECT FOUND_ROWS() as cnt
        ";
        $rResultFilterTotal = $conn->execute($sQuery);
        $aResultFilterTotal = $rResultFilterTotal ->fetchAll('assoc');
        $iFilteredTotal = $aResultFilterTotal[0]['cnt'];
        /* Total data set length */
        
        $sQuery = "SELECT count(*) as cnt FROM(
        SELECT mg.group_id ,
        (SELECT COUNT(id) FROM auctions WHERE group_id = mg.group_id AND auction_winner_member =mg.user_id) as auction_winner, Pending_Installments(mg.group_id,mg.user_id) AS pi FROM members_groups mg INNER JOIN groups g ON g.id = mg.group_id INNER JOIN users u ON mg.user_id = u.id WHERE (g.created_by = 1 AND mg.is_transfer_user =0 and mg.new_user_id=0  AND mg.group_id in (SELECT Auctions.group_id  FROM auctions Auctions WHERE auction_group_due_date < CURRENT_DATE() GROUP BY group_id ORDER BY group_id ASC) ) HAVING (pi >= 3 AND auction_winner = 0) ORDER BY mg.group_id ASC, mg.user_id ASC) as cnt";
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

     public function GetSuperAdminData($user_id) { 
        $aColumns = array('r.name', 'u.email','u.first_name','u.last_name','u.gender','u.status' );
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "u.id";
        /* DB table to use */
        $sTable = "users u";
       
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
        }
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $config_role_superadmin = Configure::read('ROLE_SUPERADMIN'); 
        $sWhere = "WHERE r.name != '".$config_role_superadmin."' ";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))." ,u.id as actions
        FROM   $sTable  left JOIN roles r on u.role_id = r.id 
        $sWhere
        $sOrder
        $sLimit
        ";
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
        FROM   $sTable left JOIN roles r on u.role_id = r.id 
        where r.name= '".$config_role_superadmin."'
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


    public function GetRoleWiseData($user_id,$role_name) { 
        $aColumns = array('u.email','u.first_name','u.last_name','u.gender','u.status' );
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "u.id";
        /* DB table to use */
        $sTable = "users u";
       
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
        }
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $config_role_member = $role_name; 
        $sWhere = "WHERE r.name = '".$config_role_member."' and u.created_by= '".$user_id."' ";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))." ,u.id as actions
        FROM   $sTable  left JOIN roles r on u.role_id = r.id 
        $sWhere
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
        FROM   $sTable left JOIN roles r on u.role_id = r.id 
        where r.name= '".$config_role_member."'
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
}
