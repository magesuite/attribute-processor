<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Test\Integration\Service\Category;

class AttributeProcessorActiveTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    private $categoryRepository;

    protected function setUp() // @codingStandardsIgnoreLine
    {
        $this->categoryRepository = \Magento\TestFramework\ObjectManager::getInstance()
            ->get(\Magento\Catalog\Api\CategoryRepositoryInterface::class);
    }

    /**
     * @magentoDataFixture loadCategories
     */
    public function testCategoryGetDataMethodReturnsValueFromProcessor()
    {
        $category = $this->categoryRepository->get(3);

        $this->assertNotNull($category->getData('attribute_processor_active'));
        $this->assertNotNull($category->getAttributeProcessorActive());
        $this->assertSame(true, $category->getData('attribute_processor_active'));
        $this->assertSame(true, $category->getAttributeProcessorActive());
    }

    /**
     * @magentoDataFixture loadCategories
     */
    public function testGetValueMethodSkipsProcessingForExistingAttribute()
    {
        $category = $this->categoryRepository->get(3);
        $category->setData('attribute_processor_active', 'original_attribute_value');

        $this->assertNotNull($category->getData('attribute_processor_active'));
        $this->assertNotNull($category->getAttributeProcessorActive());
        $this->assertSame('original_attribute_value', $category->getData('attribute_processor_active'));
        $this->assertSame('original_attribute_value', $category->getAttributeProcessorActive());

        $category->unsetData('attribute_processor_active');

        $this->assertNotNull($category->getData('attribute_processor_active'));
        $this->assertNotNull($category->getAttributeProcessorActive());
        $this->assertSame(true, $category->getData('attribute_processor_active'));
        $this->assertSame(true, $category->getAttributeProcessorActive());
    }

    public static function loadCategories()
    {
        require __DIR__ . '/../../_fixtures/categories.php'; // @codingStandardsIgnoreLine
    }

    public static function loadCategoriesRollback()
    {
        require __DIR__ . '/../../_fixtures/categories_rollback.php'; // @codingStandardsIgnoreLine
    }
}
