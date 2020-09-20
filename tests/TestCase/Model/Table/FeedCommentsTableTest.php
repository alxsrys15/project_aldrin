<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeedCommentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeedCommentsTable Test Case
 */
class FeedCommentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FeedCommentsTable
     */
    public $FeedComments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FeedComments',
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
        $config = TableRegistry::getTableLocator()->exists('FeedComments') ? [] : ['className' => FeedCommentsTable::class];
        $this->FeedComments = TableRegistry::getTableLocator()->get('FeedComments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FeedComments);

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
