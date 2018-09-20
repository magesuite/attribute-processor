<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Integration\Plugin\Sales\Model\Order;

class AroundGetDataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    private $objectManager;

    /**
     * @var string
     */
    private $pluginName = 'creativestyle_attribute_processor_sales_model_order_plugin';

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
    }

    /**
     * @return array
     */
    private function getOrderModelPluginInfo()
    {
        /** @var \Magento\TestFramework\Interception\PluginList $pluginList */
        $pluginList = $this->objectManager->create(\Magento\TestFramework\Interception\PluginList::class); // @codingStandardsIgnoreLine
        return $pluginList->get(\Magento\Sales\Model\Order::class, []);
    }

    public function testPluginIsConfiguredToWrapGetDataMethod()
    {
        $pluginInfo = $this->getOrderModelPluginInfo();
        $this->assertTrue(method_exists(
            \MageSuite\AttributeProcessor\Plugin\Sales\Model\Order\AroundGetData::class,
            'aroundGetData'
        ));
        $this->assertArrayHasKey($this->pluginName, $pluginInfo);
        $this->assertSame(
            \MageSuite\AttributeProcessor\Plugin\Sales\Model\Order\AroundGetData::class,
            $pluginInfo[$this->pluginName]['instance']
        );
    }
}
