<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AgentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AgentsTable Test Case
 */
class AgentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AgentsTable
     */
    protected $Agents;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Agents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Agents') ? [] : ['className' => AgentsTable::class];
        $this->Agents = TableRegistry::getTableLocator()->get('Agents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Agents);

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
}
