<?php
/**
 * creativeshop
 *
 * @author    Marek Zabrowarny <marek.zabrowarny@creativestyle.pl>
 * @copyright 2018 creativestyle
 */

namespace MageSuite\AttributeProcessor\Service;

class ProcessorRegistry implements \MageSuite\AttributeProcessor\Api\ProcessorRegistryInterface
{
    /**
     * @var array
     */
    private $processors = [];

    public function __construct(
        array $entityTypes = [],
        array $processors = []
    ) {
        $processors = array_filter(
            $processors,
            function ($entityType) use ($entityTypes) {
                return array_key_exists($entityType, $entityTypes);
            },
            ARRAY_FILTER_USE_KEY
        );

        foreach ($processors as $entityType => $entityAttributesProcessors) {
            $this->processors[$entityType] = array_filter(
                $entityAttributesProcessors,
                function ($entityProcessor) use ($entityType, $entityTypes) {
                    return $entityProcessor instanceof $entityTypes[$entityType];
                }
            );
        }
    }

    /**
     * @param string $entityType
     * @param string $attributeKey
     * @return mixed|null
     */
    public function get($entityType, $attributeKey)
    {
        if (array_key_exists($entityType, $this->processors)) {
            if (array_key_exists($attributeKey, $this->processors[$entityType])) {
                return $this->processors[$entityType][$attributeKey];
            }
        }
        return null;
    }
}
