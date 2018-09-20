<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Unit\Plugin\Catalog\Model\Category;

class AroundGetDataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $processorRepositoryMock;

    /**
     * @var \MageSuite\AttributeProcessor\Api\CategoryProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $processorMock;

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->processorRepositoryMock = $this->getMockBuilder(
            \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface::class
        )->getMock();

        $this->processorMock = $this->getMockBuilder(
            \MageSuite\AttributeProcessor\Api\CategoryProcessorInterface::class
        )->getMock();
    }

    private function prepareProcessorMockForGetValueCall($returnValue)
    {
        $this->processorMock->method('getValue')
            ->will($this->returnCallback(
                function ($category, $key, $index = null, $defaultValue = null) use ($returnValue) {
                    return $defaultValue === null ? $returnValue : $defaultValue;
                }
            ));

        $this->processorRepositoryMock->method('get')
            ->willReturn($this->processorMock);
    }

    public function testItCanBeInstantiated()
    {
        $instance = new \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Category\AroundGetData(
            $this->processorRepositoryMock
        );
        $this->assertInstanceOf(
            \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Category\AroundGetData::class,
            $instance
        );
    }

    public function testItGetsValueFromProcessor()
    {
        $expectedValue = 42;
        $this->prepareProcessorMockForGetValueCall($expectedValue);
        /** @var \Magento\Catalog\Model\Category|\PHPUnit_Framework_MockObject_MockObject $categoryMock */
        $categoryMock = $this->getMockBuilder(\Magento\Catalog\Model\Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $instance = new \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Category\AroundGetData(
            $this->processorRepositoryMock
        );

        $this->assertSame(
            $expectedValue,
            $instance->aroundGetData(
                $categoryMock,
                function () {
                    return null;
                },
                'category_attribute_1'
            )
        );
    }

    public function testItReturnsWrappedMethodResultIfNoProcessorIsFound()
    {
        $defaultValue = 42;
        $this->processorRepositoryMock->method('get')
            ->willReturn(null);
        /** @var \Magento\Catalog\Model\Category|\PHPUnit_Framework_MockObject_MockObject $categoryMock */
        $categoryMock = $this->getMockBuilder(\Magento\Catalog\Model\Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $instance = new \MageSuite\AttributeProcessor\Plugin\Catalog\Model\Category\AroundGetData(
            $this->processorRepositoryMock
        );

        $this->assertSame(
            $defaultValue,
            $instance->aroundGetData(
                $categoryMock,
                function () use ($defaultValue) {
                    return $defaultValue;
                },
                'category_attribute_1'
            )
        );
    }
}
