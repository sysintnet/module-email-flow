<?php

namespace Sysint\EmailFlow\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Authentication implements ArrayInterface
{
    /** @var int */
    public const AUTH_TYPE_NONE = 0;

    /** @var int */
    public const AUTH_TYPE_BASE = 1;

    /** @var int */
    public const AUTH_TYPE_KEY = 2;

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray() : array
    {
        return [
            [
                'value' => self::AUTH_TYPE_NONE,
                'label' => __('NONE')
            ],
            [
                'value' => self::AUTH_TYPE_BASE,
                'label' => __('Basic Auth')
            ],
            [
                'value' => self::AUTH_TYPE_KEY,
                'label' => __('Header Auth')
            ]
        ];
    }
}
