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

/** @var \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository  */
$categoryRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
    ->get(\Magento\Catalog\Api\CategoryRepositoryInterface::class); // @codingStandardsIgnoreLine

try {
    $category = $categoryRepository->get(3);
    $categoryRepository->delete($category);
} catch (\Magento\Framework\Exception\NoSuchEntityException $e) { // @codingStandardsIgnoreLine
    //Category already removed
}

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', false);
