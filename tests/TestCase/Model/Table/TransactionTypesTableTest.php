<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransactionTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransactionTypesTable Test Case
 */
class TransactionTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransactionTypesTable
     */
    public $TransactionTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.TransactionTypes',
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
        $config = TableRegistry::getTableLocator()->exists('TransactionTypes') ? [] : ['className' => TransactionTypesTable::class];
        $this->TransactionTypes = TableRegistry::getTableLocator()->get('TransactionTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TransactionTypes);

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
}
