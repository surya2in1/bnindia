<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuctionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuctionsTable Test Case
 */
class AuctionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AuctionsTable
     */
    protected $Auctions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Auctions',
        'app.Groups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Auctions') ? [] : ['className' => AuctionsTable::class];
        $this->Auctions = TableRegistry::getTableLocator()->get('Auctions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Auctions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
