<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Integration\Service\Product;

class AttributeProcessorActiveTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->productRepository = \Magento\TestFramework\ObjectManager::getInstance()
            ->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture loadProducts
     */
    public function testProductGetDataMethodReturnsGetValueMethodResult()
    {
        $product = $this->productRepository->get('simple');

        $this->assertNotNull($product->getData('attribute_processor_active'));
        $this->assertNotNull($product->getAttributeProcessorActive());
        $this->assertSame(true, $product->getData('attribute_processor_active'));
        $this->assertSame(true, $product->getAttributeProcessorActive());
    }

    /**
     * @magentoDataFixture loadProducts
     */
    public function testGetValueMethodSkipsProcessingForExistingAttribute()
    {
        $product = $this->productRepository->get('simple');
        $product->setData('attribute_processor_active', 'original_attribute_value');

        $this->assertNotNull($product->getData('attribute_processor_active'));
        $this->assertNotNull($product->getAttributeProcessorActive());
        $this->assertSame('original_attribute_value', $product->getData('attribute_processor_active'));
        $this->assertSame('original_attribute_value', $product->getAttributeProcessorActive());

        $product->unsetData('attribute_processor_active');

        $this->assertNotNull($product->getData('attribute_processor_active'));
        $this->assertNotNull($product->getAttributeProcessorActive());
        $this->assertSame(true, $product->getData('attribute_processor_active'));
        $this->assertSame(true, $product->getAttributeProcessorActive());
    }

    public static function loadProducts()
    {
        require __DIR__ . '/../../_fixtures/products.php'; // @codingStandardsIgnoreLine
    }

    public static function loadProductsRollback()
    {
        require __DIR__ . '/../../_fixtures/products_rollback.php'; // @codingStandardsIgnoreLine
    }
}
