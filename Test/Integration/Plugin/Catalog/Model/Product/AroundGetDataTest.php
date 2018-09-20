<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Integration\Plugin\Catalog\Model\Product;

class AroundGetDataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var string
     */
    private $pluginName = 'creativestyle_attribute_processor_catalog_model_product_plugin';

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
    }

    /**
     * @return array
     */
    private function getProductModelPluginInfo()
    {
        /** @var \Magento\TestFramework\Interception\PluginList $pluginList */
        $pluginList = $this->objectManager->create(\Magento\TestFramework\Interception\PluginList::class); // @codingStandardsIgnoreLine
        return $pluginList->get(\Magento\Catalog\Model\Product::class, []);
    }

    public function testPluginIsConfiguredToWrapGetDataMethod()
    {
        $pluginInfo = $this->getProductModelPluginInfo();
        $this->assertTrue(method_exists(
            \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Product\AroundGetData::class,
            'aroundGetData'
        ));
        $this->assertArrayHasKey($this->pluginName, $pluginInfo);
        $this->assertSame(
            \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Product\AroundGetData::class,
            $pluginInfo[$this->pluginName]['instance']
        );
    }
}
