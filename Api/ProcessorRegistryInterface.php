<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Api;

interface ProcessorRegistryInterface
{
    /**
     * @param string $entityType
     * @param string $attributeKey
     * @return mixed
     */
    public function get($entityType, $attributeKey);
}
