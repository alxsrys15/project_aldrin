<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HistInventoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HistInventoryTable Test Case
 */
class HistInventoryTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HistInventoryTable
     */
    public $HistInventory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.HistInventory',
        'app.ProductStocks',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('HistInventory') ? [] : ['className' => HistInventoryTable::class];
        $this->HistInventory = TableRegistry::getTableLocator()->get('HistInventory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HistInventory);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
