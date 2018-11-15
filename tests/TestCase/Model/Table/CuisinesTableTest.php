<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CuisinesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CuisinesTable Test Case
 */
class CuisinesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CuisinesTable
     */
    public $Cuisines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cuisines',
        'app.restaurants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cuisines') ? [] : ['className' => CuisinesTable::class];
        $this->Cuisines = TableRegistry::getTableLocator()->get('Cuisines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cuisines);

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
