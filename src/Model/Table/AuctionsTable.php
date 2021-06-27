<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

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
        $this->belongsTo('Users', [
            'foreignKey' => 'auction_winner_member',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'auction_id',
        ]);
        $this->hasMany('PaymentVouchers', [
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

        $validator->add('auction_date', 'wrong_auction_date', [
            'rule' => function ($value, $context) {
                $auction_date = isset($context['data']['auction_date']) ? $context['data']['auction_date'] : '';
                $last_auction_date = isset($context['data']['last_auction_date']) && !empty($context['data']['last_auction_date']) ? $context['data']['last_auction_date'] : '';

                if( $last_auction_date){

                    $group_type = isset($context['data']['group_type']) ? $context['data']['group_type'] : '';
                     
                    //generate next auction date as per group type
                    if($group_type == Configure::read('monthly')){ 
                        $last_dt_auction_date = date('Y-m-01', strtotime('+1 month', strtotime($last_auction_date))); 
                        $last_dt_of_next_auctiondt_month = date('Y-m-t', strtotime('+1 month', strtotime($last_auction_date)));
                    }

                    if($group_type == Configure::read('fortnight')){ 
                        if($last_auction_date >= date('Y-m-01',strtotime($last_auction_date)) && $last_auction_date <= date('Y-m-15',strtotime($last_auction_date)) ){

                            $last_dt_auction_date = date('Y-m-16',strtotime($last_auction_date));
                            $last_dt_of_next_auctiondt_month =date('Y-m-t',strtotime($last_auction_date));
                        } 
                        if($last_auction_date >= date('Y-m-16',strtotime($last_auction_date)) && $last_auction_date <= date('Y-m-t',strtotime($last_auction_date)) ){

                            $last_dt_auction_date = date('Y-m-01',strtotime('+1 month', strtotime($last_auction_date)));
                            $last_dt_of_next_auctiondt_month =date('Y-m-15',strtotime('+1 month', strtotime($last_auction_date)));
                        }
                    }

                    if($group_type == Configure::read('weekly')){
                        $last_dt_auction_date = date('Y-m-d', strtotime('next monday', strtotime($last_auction_date)));
                        $last_dt_of_next_auctiondt_month = date('Y-m-d', strtotime('next sunday', strtotime($last_dt_auction_date)));
                    }

                    if($group_type == Configure::read('daily')){
                        $nextday = date('Y-m-d', strtotime($last_auction_date. ' + 1 days'));
                        $last_dt_auction_date = $nextday;
                        $last_dt_of_next_auctiondt_month = $nextday;
                    }

                     // echo  '$auction_date = '.$auction_date.' // last_dt_auction_date= '.$last_dt_auction_date.' // last_dt_of_next_auctiondt_month = '.$last_dt_of_next_auctiondt_month;
                     // exit;
                    if($auction_date >= $last_dt_auction_date && $auction_date <= $last_dt_of_next_auctiondt_month){ 
                        return true;
                    }else{ 
                        if($group_type == Configure::read('daily')){
                            return 'Please select "Auction Date" must be '.$last_dt_auction_date; 
                        }else{
                            return 'Please select "Auction Date" in between '.$last_dt_auction_date.' and '.$last_dt_of_next_auctiondt_month; 
                        } 
                    } 
                }else{ 
                   return true;
                }  
            },
            'message' => 'Wrong auction date',
        ]);
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
        // $rules->add($rules->isUnique(['auction_no', 'group_id']));
        // $rules->add($rules->isUniqueAuctionDate(['auction_date', 'group_id']));
        $rules->add($rules->existsIn(['group_id'], 'Groups'));

        return $rules;
    }

    //Function for ajax listing, filter, sort, search
    public function GetData() {
        $ucase_first_name = "CONCAT(UCASE(LEFT(u.first_name, 1)),SUBSTRING(u.first_name, 2)) "; 
        $ucase_middle_name = "CONCAT(UCASE(LEFT(u.middle_name, 1)),SUBSTRING(u.middle_name, 2)) "; 
        $ucase_last_name = "CONCAT(UCASE(LEFT(u.last_name, 1)),SUBSTRING(u.last_name, 2)) "; 
        
        $aColumns = array( 'a.id','g.group_code','a.auction_no','a.auction_date','a.auction_highest_percent',"concat($ucase_first_name,' ', $ucase_middle_name,' ',$ucase_last_name) as winner",'a.chit_amount','a.priced_amount','a.foreman_commission','a.total_subscriber_dividend','a.subscriber_dividend','a.net_subscription_amount' );
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "a.id";
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
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))." 
        FROM   $sTable join groups g on g.id = a.group_id join users u on u.id = a.auction_winner_member
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
