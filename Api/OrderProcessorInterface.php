<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Api;

interface OrderProcessorInterface
{
    /**
     * @param \Magento\Sales\Model\Order $order
     * @param string $key
     * @param string|null $index
     * @param mixed|null $defaultValue
     * @return mixed
     */
    public function getValue(\Magento\Sales\Model\Order $order, $key = '', $index = null, $defaultValue = null);
}
