<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeedDislikesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeedDislikesTable Test Case
 */
class FeedDislikesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FeedDislikesTable
     */
    public $FeedDislikes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FeedDislikes',
        'app.Feeds',
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
        $config = TableRegistry::getTableLocator()->exists('FeedDislikes') ? [] : ['className' => FeedDislikesTable::class];
        $this->FeedDislikes = TableRegistry::getTableLocator()->get('FeedDislikes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FeedDislikes);

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
