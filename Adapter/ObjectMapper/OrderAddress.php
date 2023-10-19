<?php

namespace Sysint\EmailFlow\Adapter\ObjectMapper;

use Magento\Sales\Model\Order\Address;

class OrderAddress implements ObjectMapperInterface
{
    /**
     * Return values for the object
     * @param mixed $object
     * @return array
     */
    public function getValues($object): array
    {
        if ($object instanceof Address) {
            $keys = [
                'firstname', 'middlename', 'lastname', 'suffix', 'company',
                'city', 'region', 'region_id', 'postcode', 'country_id', 'telephone', 'fax',
                'email', 'address_type', 'street'
            ];
            return $object->toArray($keys);
        }
        return [];
    }
}
