<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Unit\Plugin\Catalog\Model\Product;

class AroundGetDataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $processorRepositoryMock;

    /**
     * @var \MageSuite\AttributeProcessor\Api\ProductProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $processorMock;

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->processorRepositoryMock = $this->getMockBuilder(
            \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface::class
        )->getMock();

        $this->processorMock = $this->getMockBuilder(
            \MageSuite\AttributeProcessor\Api\ProductProcessorInterface::class
        )->getMock();
    }

    private function prepareProcessorMockForGetValueCall($returnValue)
    {
        $this->processorMock->method('getValue')
            ->will($this->returnCallback(
                function ($product, $key, $index = null, $defaultValue = null) use ($returnValue) {
                    return $defaultValue === null ? $returnValue : $defaultValue;
                }
            ));

        $this->processorRepositoryMock->method('get')
            ->willReturn($this->processorMock);
    }

    public function testItCanBeInstantiated()
    {
        $instance = new \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Product\AroundGetData(
            $this->processorRepositoryMock
        );
        $this->assertInstanceOf(
            \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Product\AroundGetData::class,
            $instance
        );
    }

    public function testItGetsValueFromProcessor()
    {
        $expectedValue = 42;
        $this->prepareProcessorMockForGetValueCall($expectedValue);
        /** @var \Magento\Catalog\Model\Product|\PHPUnit_Framework_MockObject_MockObject $productMock */
        $productMock = $this->getMockBuilder(\Magento\Catalog\Model\Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $instance = new \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Product\AroundGetData(
            $this->processorRepositoryMock
        );

        $this->assertSame(
            $expectedValue,
            $instance->aroundGetData(
                $productMock,
                function () {
                    return null;
                },
                'product_attribute_1'
            )
        );
    }

    public function testItReturnsWrappedMethodResultIfNoProcessorIsFound()
    {
        $defaultValue = 42;
        $this->processorRepositoryMock->method('get')
            ->willReturn(null);
        /** @var \Magento\Catalog\Model\Product|\PHPUnit_Framework_MockObject_MockObject $productMock */
        $productMock = $this->getMockBuilder(\Magento\Catalog\Model\Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $instance = new \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Product\AroundGetData(
            $this->processorRepositoryMock
        );

        $this->assertSame(
            $defaultValue,
            $instance->aroundGetData(
                $productMock,
                function () use ($defaultValue) {
                    return $defaultValue;
                },
                'product_attribute_1'
            )
        );
    }
}
