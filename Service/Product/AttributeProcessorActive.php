<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Service\Product;

class AttributeProcessorActive implements \MageSuite\AttributeProcessor\Api\ProductProcessorInterface
{
    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param string $key
     * @param string|null $index
     * @param mixed|null $defaultValue
     * @return mixed
     */
    public function getValue(\Magento\Catalog\Model\Product $product, $key = '', $index = null, $defaultValue = null) // @codingStandardsIgnoreLine
    {
        if (null === $defaultValue) {
            return true;
        }
        return $defaultValue;
    }
}
