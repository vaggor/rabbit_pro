<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BreedersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BreedersTable Test Case
 */
class BreedersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BreedersTable
     */
    public $Breeders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Breeders',
        'app.Breeds',
        'app.Sexes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Breeders') ? [] : ['className' => BreedersTable::class];
        $this->Breeders = TableRegistry::getTableLocator()->get('Breeders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Breeders);

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
