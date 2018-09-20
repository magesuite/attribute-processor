<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Api;

interface CategoryProcessorInterface
{
    /**
     * @param \Magento\Catalog\Model\Category $category
     * @param string $key
     * @param string|null $index
     * @param mixed|null $defaultValue
     * @return mixed
     */
    public function getValue(\Magento\Catalog\Model\Category $category, $key = '', $index = null, $defaultValue = null);
}
