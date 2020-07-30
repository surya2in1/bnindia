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

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    public function GetData() {
        $aColumns = array( 'id','email','first_name','last_name','gender','password','status' );
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";
        /* DB table to use */
        $sTable = "users";
        App::uses('ConnectionManager', 'Model');
        $dataSource = ConnectionManager::getDataSource('default');
        /* Database connection information */
        $gaSql['root']       = $dataSource->config['login'];
        $gaSql['']   = $dataSource->config['password'];
        $gaSql['user']         = $dataSource->config['database'];
        $gaSql['localhost']     = $dataSource->config['host'];
        
        function fatal_error ( $sErrorMessage = '' )
        {
            header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
            die( $sErrorMessage );
        }
        /*
        * MySQL connection
        */
        if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['localhost'], $gaSql['root'], $gaSql['']  ) )
        {
            fatal_error( 'Could not open connection to server' );
        }
        if ( ! mysql_select_db( $gaSql['user'], $gaSql['link'] ) )
        {
            fatal_error( 'Could not select database ' );
        }
        /*
        * Paging
        */
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
            intval( $_GET['iDisplayLength'] );
        }
        /*
        * Ordering
        */
        $sOrder = "";
        if ( isset( $_GET['iSortCol_0'] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
            {
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                {
                    $sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
                    ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
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
        if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
        {
            $sWhere = "WHERE (";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ')';
        }
        /* Individual column filtering */
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
            {
                if ( $sWhere == "" )
                {
                    $sWhere = "WHERE ";
                }
                else
                {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
            }
        }
        /*
        * SQL queries
        * Get data to display
        */
        $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
        ";
        $rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
        /* Data set length after filtering */
        $sQuery = "
        SELECT FOUND_ROWS()
        ";
        $rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
        $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $aResultFilterTotal[0];
        /* Total data set length */
        $sQuery = "
        SELECT COUNT(`".$sIndexColumn."`)
        FROM   $sTable
        ";
        $rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
        $aResultTotal = mysql_fetch_array($rResultTotal);
        $iTotal = $aResultTotal[0];
        /*
        * Output
        */
        $output = array(
        /*"sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
        */
        "draw" => intval($_GET['sEcho']),
        "recordsTotal" => $iTotal,
        "recordsFiltered" => $iFilteredTotal,
        "data" => array()
        );
        while ( $aRow = mysql_fetch_array( $rResult ) )
        {
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ )
            {
                if ( $aColumns[$i] == "version" )
                {
                    /* Special output formatting for 'version' column */
                    $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
                }
                else if ( $aColumns[$i] != ' ' )
                {
                    /* General output */
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            $output['data'][] = $row;
        }
        return $output;
    }
}
