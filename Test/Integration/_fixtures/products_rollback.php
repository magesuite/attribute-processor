<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

/** @var \Magento\Framework\Registry $registry */
$registry = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->get(\Magento\Framework\Registry::class); // @codingStandardsIgnoreLine

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

/** @var Magento\Catalog\Api\ProductRepositoryInterface $productRepository  */
$productRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
    ->get(\Magento\Catalog\Api\ProductRepositoryInterface::class); // @codingStandardsIgnoreLine

try {
    $product = $productRepository->get('simple', false, null, true);
    $productRepository->delete($product);
} catch (\Magento\Framework\Exception\NoSuchEntityException $e) { // @codingStandardsIgnoreLine
    //Product already removed
}

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);
