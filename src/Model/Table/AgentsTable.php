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

        $this->hasMany('Users', [
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
            //->requirePresence('address_proof', 'create')
            ->allowEmptyString('address_proof');

        $validator
            ->scalar('pan_card')
            ->maxLength('pan_card', 500)
            //->requirePresence('pan_card', 'create')
            ->allowEmptyString('pan_card');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 500)
            //->requirePresence('photo', 'create')
            ->allowEmptyString('photo');

        $validator
            ->scalar('educational_proof')
            ->maxLength('educational_proof', 500)
            //->requirePresence('educational_proof', 'create')
            ->allowEmptyString('educational_proof');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 500)
            ->requirePresence('bank_name', 'create')
            ->notEmptyString('bank_name');

        $validator
            ->scalar('account_no')
            ->maxLength('account_no', 30)
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

    /**
     * Create agent code as PM0025 
     * P - Current branch first latter
     * M - Agent first latter
     * 0025 - Agent serial no
     */
    function get_agent_code($current_user_id,$agent_name,$branch_name,$existing_agent_id=0){ 
        if($existing_agent_id<1){
            //get serial no for agent
            $conn = ConnectionManager::get('default');
            $stmt = $conn->execute("call CreateAgentId($current_user_id,@p3)");
            $stmt = $conn->execute("SELECT @p3 AS agent_id");
            
            $result = $stmt ->fetchAll('assoc');
            // echo '<pre>';print_r($result); 
            $agent_id =isset($result[0]['agent_id']) && ($result[0]['agent_id']>0) ? $result[0]['agent_id'] : 0;
        }else{
            $agent_id = $existing_agent_id;
        }
        $first_later_agent = ucfirst(substr($agent_name, 0, 1));
        $first_later_branch = ucfirst(substr($branch_name, 0, 1));
        $agent_id_length = strlen((string)$agent_id);
        if($agent_id_length < 4){
             $cust_no ='000';
            for($i=1;$i<$agent_id_length;$i++){
                $cust_no =substr($cust_no, 1);
                
            }
            $customer_no  = $cust_no.$agent_id;  
        }else{
            $customer_no  =$agent_id;
        }
        // echo $member_role_id.' - '.$current_user_id.' - '.$agent_name.' - '.$branch_name."<br/>";
        return $first_later_branch.$first_later_agent.$customer_no;
    }

    //Function for ajax listing, filter, sort, search
    public function GetData($user_id) {  
        $aColumns = array( 'a.agent_code','a.email','a.name','a.mobile_number','a.bank_name','a.account_no');
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "a.id";
        /* DB table to use */
        $sTable = "agents a";
       
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
               $sOrder = " ORDER BY a.id desc ";
            }
        } 
        /*
        * Filtering
        * NOTE this does not match the built-in DataTables filtering which does it
        * word by word on any field. It's possible to do here, but concerned about efficiency
        * on very large tables, and MySQL's regex functionality is very limited
        */
        $sWhere = " WHERE a.created_by= '".$user_id."' AND status=0  ";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))." , a.id as actions
        FROM   $sTable  
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
}
