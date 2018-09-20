<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Unit\Plugin\Sales\Model\Order;

class AroundGetDataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $processorRepositoryMock;

    /**
     * @var \MageSuite\AttributeProcessor\Api\OrderProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $processorMock;

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->processorRepositoryMock = $this->getMockBuilder(
            \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface::class
        )->getMock();

        $this->processorMock = $this->getMockBuilder(
            \MageSuite\AttributeProcessor\Api\OrderProcessorInterface::class
        )->getMock();
    }

    private function prepareProcessorMockForGetValueCall($returnValue)
    {
        $this->processorMock->method('getValue')
            ->will($this->returnCallback(
                function ($order, $key, $index = null, $defaultValue = null) use ($returnValue) {
                    return $defaultValue === null ? $returnValue : $defaultValue;
                }
            ));

        $this->processorRepositoryMock->method('get')
            ->willReturn($this->processorMock);
    }

    public function testItCanBeInstantiated()
    {
        $instance = new \MageSuite\AttributeProcessor\Plugin\Sales\Model\Order\AroundGetData(
            $this->processorRepositoryMock
        );
        $this->assertInstanceOf(
            \MageSuite\AttributeProcessor\Plugin\Sales\Model\Order\AroundGetData::class,
            $instance
        );
    }

    public function testItGetsValueFromProcessor()
    {
        $expectedValue = 42;
        $this->prepareProcessorMockForGetValueCall($expectedValue);
        /** @var \Magento\Sales\Model\Order|\PHPUnit_Framework_MockObject_MockObject $orderMock */
        $orderMock = $this->getMockBuilder(\Magento\Sales\Model\Order::class)
            ->disableOriginalConstructor()
            ->getMock();

        $instance = new \MageSuite\AttributeProcessor\Plugin\Sales\Model\Order\AroundGetData(
            $this->processorRepositoryMock
        );

        $this->assertSame(
            $expectedValue,
            $instance->aroundGetData(
                $orderMock,
                function () {
                    return null;
                },
                'order_attribute_1'
            )
        );
    }

    public function testItReturnsWrappedMethodResultIfNoProcessorIsFound()
    {
        $defaultValue = 42;
        $this->processorRepositoryMock->method('get')
            ->willReturn(null);
        /** @var \Magento\Sales\Model\Order|\PHPUnit_Framework_MockObject_MockObject $orderMock */
        $orderMock = $this->getMockBuilder(\Magento\Sales\Model\Order::class)
            ->disableOriginalConstructor()
            ->getMock();

        $instance = new \MageSuite\AttributeProcessor\Plugin\Sales\Model\Order\AroundGetData(
            $this->processorRepositoryMock
        );

        $this->assertSame(
            $defaultValue,
            $instance->aroundGetData(
                $orderMock,
                function () use ($defaultValue) {
                    return $defaultValue;
                },
                'order_attribute_1'
            )
        );
    }
}
