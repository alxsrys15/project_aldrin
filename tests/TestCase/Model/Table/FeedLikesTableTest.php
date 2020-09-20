<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeedLikesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeedLikesTable Test Case
 */
class FeedLikesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FeedLikesTable
     */
    public $FeedLikes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FeedLikes',
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
        $config = TableRegistry::getTableLocator()->exists('FeedLikes') ? [] : ['className' => FeedLikesTable::class];
        $this->FeedLikes = TableRegistry::getTableLocator()->get('FeedLikes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FeedLikes);

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
