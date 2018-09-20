<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Unit\Service;

class ProcessorRegistryTest extends \PHPUnit\Framework\TestCase
{
    public function testItCanBeInstantiated()
    {
        $instance = new \MageSuite\AttributeProcessor\Service\ProcessorRegistry();
        $this->assertInstanceOf(\MageSuite\AttributeProcessor\Service\ProcessorRegistry::class, $instance);
        $this->assertInstanceOf(\MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface::class, $instance);
    }

    public function testItRegistersProcessorsForAllowedEntityTypesOnly()
    {
        $allowedEntityTypes = [
            'catalog_product' => \stdClass::class,
            'yet_another_entity' => \stdClass::class
        ];

        $processorMocks = [
            'catalog_product' => [
                'product_attribute_1' => $this->getMockBuilder(\stdClass::class)->getMock(),
                'product_attribute_2' => $this->getMockBuilder(\stdClass::class)->getMock()
            ],
            'catalog_category' => [
                'category_attribute_1' => $this->getMockBuilder(\stdClass::class)->getMock(),
                'category_attribute_2' => $this->getMockBuilder(\stdClass::class)->getMock()
            ],
            'yet_another_entity' => [
                'yet_another_attribute' => $this->getMockBuilder(\stdClass::class)->getMock()
            ],
            'yet_another_disallowed_entity' => [
                'some_attribute' => $this->getMockBuilder(\stdClass::class)->getMock()
            ]
        ];

        $instance = new \MageSuite\AttributeProcessor\Service\ProcessorRegistry(
            $allowedEntityTypes,
            $processorMocks
        );

        foreach ($processorMocks as $entityType => $entityProcessors) {
            foreach ($entityProcessors as $attributeKey => $processor) {
                $this->assertSame(
                    array_key_exists($entityType, $allowedEntityTypes) ? $processor : null,
                    $instance->get($entityType, $attributeKey)
                );
            }
        }
    }

    public function testItRegistersProcessorsOfCorrespondingInterfaceOnly()
    {
        $allowedEntityTypes = ['catalog_product' => DummyProcessorInterface::class];

        $processorMocks = [
            'catalog_product' => [
                'product_attribute_1' => $this->getMockBuilder(\stdClass::class)->getMock(),
                'product_attribute_2' => $this->getMockBuilder(DummyProcessorInterface::class)->getMock()
            ],
            'yet_another_disallowed_entity' => [
                'some_attribute' => $this->getMockBuilder(DummyProcessorInterface::class)->getMock()
            ]
        ];

        $instance = new \MageSuite\AttributeProcessor\Service\ProcessorRegistry(
            $allowedEntityTypes,
            $processorMocks
        );

        $this->assertNull($instance->get('catalog_product', 'product_attribute_1'));
        $this->assertNull($instance->get('yet_another_disallowed_entity', 'some_attribute'));
        $this->assertSame(
            $processorMocks['catalog_product']['product_attribute_2'],
            $instance->get('catalog_product', 'product_attribute_2')
        );
    }
}
