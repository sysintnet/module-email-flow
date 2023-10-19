<?php

namespace Sysint\EmailFlow\Adapter\ObjectMapper;

use Magento\Sales\Model\Order\Item;
use Magento\Catalog\Helper\Product as ProductHelper;

class Order implements ObjectMapperInterface
{
    /** @var ProductHelper */
    private $productHelper;

    /**
     * @param ProductHelper $productHelper
     */
    public function __construct(ProductHelper $productHelper)
    {
        $this->productHelper = $productHelper;
    }

    /**
     * Return values for the object
     * @param mixed $object
     * @return array
     */
    public function getValues($object): array
    {
        if ($object instanceof \Magento\Sales\Model\Order) {
            return $this->getInformation($object);
        }
        return [];
    }

    /**
     * Returns general information about order
     * @param \Magento\Sales\Model\Order $order
     * @return array
     */
    private function getInformation(\Magento\Sales\Model\Order $order) : array
    {
        $information = [
            'items' => $this->getOrderItems($order)
        ];
        foreach ($order->getData() as $key => $value) {
            if (is_scalar($value) === true) {
                $information[$key] = $value;
            }
        }

        return $information;
    }

    /**
     * Returns order items information
     * @param \Magento\Sales\Model\Order $order
     * @return array
     */
    private function getOrderItems(\Magento\Sales\Model\Order $order) : array
    {
        /**
         * @todo
         * - Product Link
         * - Product Image
         */
        $information = [];
        /** @var Item $orderItem */
        foreach ($order->getAllVisibleItems() as $orderItem) {
            $orderItem->unsetData(['product_options', 'extension_attributes']);
            $information[] = array_merge(
                $orderItem->toArray(),
                [
                    'url' => $orderItem->getProduct()->getProductUrl(),
                    'image' => $this->productHelper->getThumbnailUrl($orderItem->getProduct())
                ]
            );
        }

        return $information;
    }
}
