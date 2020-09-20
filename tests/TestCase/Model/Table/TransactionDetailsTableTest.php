<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransactionDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransactionDetailsTable Test Case
 */
class TransactionDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransactionDetailsTable
     */
    public $TransactionDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TransactionDetails',
        'app.Products',
        'app.ProductStocks',
        'app.Transactions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TransactionDetails') ? [] : ['className' => TransactionDetailsTable::class];
        $this->TransactionDetails = TableRegistry::getTableLocator()->get('TransactionDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TransactionDetails);

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
