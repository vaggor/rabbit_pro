<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LittersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LittersTable Test Case
 */
class LittersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LittersTable
     */
    public $Litters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Litters',
        'app.Plans',
        'app.Breeds',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Litters') ? [] : ['className' => LittersTable::class];
        $this->Litters = TableRegistry::getTableLocator()->get('Litters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Litters);

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
