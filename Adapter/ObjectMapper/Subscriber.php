<?php

namespace Sysint\EmailFlow\Adapter\ObjectMapper;

class Subscriber implements ObjectMapperInterface
{
    /**
     * Return values for the object
     * @param mixed $object
     * @return array
     */
    public function getValues($object): array
    {
        if ($object instanceof \Magento\Newsletter\Model\Subscriber) {
            $keys = [
                'subscriber_status', 'customer_id',
                'store_id', 'subscriber_email',
                'change_status_at', 'subscriber_id'
            ];
            return $object->toArray($keys);
        }

        return [];
    }
}
