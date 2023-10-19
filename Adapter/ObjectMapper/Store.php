<?php

namespace Sysint\EmailFlow\Adapter\ObjectMapper;

class Store implements ObjectMapperInterface
{
    /**
     * Return values for the object
     * @param mixed $object
     * @return array
     */
    public function getValues($object): array
    {
        if ($object instanceof \Magento\Store\Model\Store) {
            $keys = ['store_id', 'code', 'website_id', 'group_id', 'name'];
            return $object->toArray($keys);
        }
        return [];
    }
}
