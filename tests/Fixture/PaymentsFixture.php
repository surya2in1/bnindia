<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PaymentsFixture
 */
class PaymentsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'receipt_no' => ['type' => 'string', 'length' => 500, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'due_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'group_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'subscriber_ticket_no' => ['type' => 'string', 'length' => 500, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'instalment_no' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'instalment_month' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'subscription_amount' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'late_fee' => ['type' => 'integer', 'length' => 10, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'received_by' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '1-cash, 2 - cheque,3 - Direct Debit', 'precision' => null],
        'cash_received_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'if received by cash', 'precision' => null],
        'cheque_no' => ['type' => 'string', 'length' => 500, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'if received by cheque', 'precision' => null],
        'cheque_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'if received by cheque', 'precision' => null],
        'cheque_bank_details' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'if received by cheque', 'precision' => null, 'autoIncrement' => null],
        'cheque_drown_on' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'if received by cheque', 'precision' => null, 'autoIncrement' => null],
        'direct_debit_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'if received by Direct debit', 'precision' => null],
        'direct_debit_transaction_no' => ['type' => 'string', 'length' => 500, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'if received by Direct debit', 'precision' => null],
        'remark' => ['type' => 'string', 'length' => 500, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'receipt_no' => 'Lorem ipsum dolor sit amet',
                'due_date' => '2021-03-19',
                'date' => '2021-03-19',
                'group_id' => 1,
                'subscriber_ticket_no' => 'Lorem ipsum dolor sit amet',
                'user_id' => 1,
                'instalment_no' => 1,
                'instalment_month' => 1,
                'subscription_amount' => 1,
                'late_fee' => 1,
                'received_by' => 1,
                'cash_received_date' => '2021-03-19',
                'cheque_no' => 'Lorem ipsum dolor sit amet',
                'cheque_date' => '2021-03-19',
                'cheque_bank_details' => 1,
                'cheque_drown_on' => 1,
                'direct_debit_date' => '2021-03-19',
                'direct_debit_transaction_no' => 'Lorem ipsum dolor sit amet',
                'remark' => 'Lorem ipsum dolor sit amet',
                'created' => 1616164024,
                'modified' => 1616164024,
            ],
        ];
        parent::init();
    }
}
