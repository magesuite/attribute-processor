<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Integration\Plugin\Catalog\Model\Category;

class AroundGetDataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var string
     */
    private $pluginName = 'creativestyle_attribute_processor_catalog_model_category_plugin';

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
    }

    /**
     * @return array
     */
    private function getCategoryModelPluginInfo()
    {
        /** @var \Magento\TestFramework\Interception\PluginList $pluginList */
        $pluginList = $this->objectManager->create(\Magento\TestFramework\Interception\PluginList::class); // @codingStandardsIgnoreLine
        return $pluginList->get(\Magento\Catalog\Model\Category::class, []);
    }

    public function testPluginIsConfiguredToWrapGetDataMethod()
    {
        $pluginInfo = $this->getCategoryModelPluginInfo();
        $this->assertTrue(method_exists(
            \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Category\AroundGetData::class,
            'aroundGetData'
        ));
        $this->assertArrayHasKey($this->pluginName, $pluginInfo);
        $this->assertSame(
            \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Category\AroundGetData::class,
            $pluginInfo[$this->pluginName]['instance']
        );
    }
}
