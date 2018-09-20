<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Plugin\Catalog\Model\Product;

class AroundGetData
{
    /**
     * @var \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface
     */
    private $processorRepository;

    /**
     * @param \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface $processorRepository
     */
    public function __construct(\MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface $processorRepository)
    {
        $this->processorRepository = $processorRepository;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param \Closure $proceed
     * @param string $key
     * @param string|null $index
     * @return mixed
     */
    public function aroundGetData(\Magento\Catalog\Model\Product $product, \Closure $proceed, $key = '', $index = null)
    {
        if ($processor = $this->processorRepository->get(\Magento\Catalog\Model\Product::ENTITY, $key)) {
            return $processor->getValue($product, $key, $index, $proceed($key, $index));
        }
        return $proceed($key, $index);
    }
}
