<?php

namespace Sysint\EmailFlow\Adapter\ObjectMapper;

interface ObjectMapperInterface
{
    /**
     * Return values for the object
     * @param mixed $object
     * @return array
     */
    public function getValues($object) : array;
}
