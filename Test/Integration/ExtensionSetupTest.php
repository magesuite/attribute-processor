<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Integration;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\ObjectManager;

class ExtensionSetupTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager; // @codingStandardsIgnoreLine

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->objectManager = ObjectManager::getInstance();
    }

    public function testExtensionIsRegisteredAsModule()
    {
        /** @var ComponentRegistrar $componentRegistrar */
        $componentRegistrar = new ComponentRegistrar();
        $this->assertArrayHasKey(
            'MageSuite_AttributeProcessor',
            $componentRegistrar->getPaths(ComponentRegistrar::MODULE)
        );
    }

    public function testModuleIsEnabled()
    {
        /** @var ModuleList $moduleList */
        $moduleList = $this->objectManager->get(ModuleList::class); // @codingStandardsIgnoreLine
        $this->assertTrue($moduleList->has('MageSuite_AttributeProcessor'));
    }
}
