<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MembersGroupsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MembersGroupsTable Test Case
 */
class MembersGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MembersGroupsTable
     */
    protected $MembersGroups;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MembersGroups',
        'app.Members',
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
        $config = TableRegistry::getTableLocator()->exists('MembersGroups') ? [] : ['className' => MembersGroupsTable::class];
        $this->MembersGroups = TableRegistry::getTableLocator()->get('MembersGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MembersGroups);

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
