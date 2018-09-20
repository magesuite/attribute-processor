<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Plugin\Sales\Model\Order;

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
     * @param \Magento\Sales\Model\Order $order
     * @param \Closure $proceed
     * @param string $key
     * @param string|null $index
     * @return mixed
     */
    public function aroundGetData(\Magento\Sales\Model\Order $order, \Closure $proceed, $key = '', $index = null)
    {
        /** @var \MageSuite\AttributeProcessor\Api\OrderProcessorInterface|null $processor */
        if ($processor = $this->processorRepository->get(\Magento\Sales\Model\Order::ENTITY, $key)) {
            return $processor->getValue($order, $key, $index, $proceed($key, $index));
        }
        return $proceed($key, $index);
    }
}
