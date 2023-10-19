<?php

namespace Sysint\EmailFlow\Adapter\ObjectMapper;

class ObjectMapperResolver implements ObjectMapperInterface
{
    /** @var ObjectMapperInterface[] */
    private $objectMappers;

    /**
     * @param ObjectMapperInterface[] $objectMappers
     */
    public function __construct(array $objectMappers)
    {
        $this->objectMappers = $objectMappers;
    }

    /**
     * Return values for the object
     * @param mixed $object
     * @return array
     */
    public function getValues($object): array
    {
        foreach ($this->objectMappers as $mapper) {
            $values = $mapper->getValues($object);
            if (empty($values) === false) {
                return $values;
            }
        }

        return [];
    }
}
