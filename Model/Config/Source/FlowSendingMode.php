<?php

namespace Sysint\EmailFlow\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class FlowSendingMode implements ArrayInterface
{
    /** @var int */
    public const MIXED = 0;

    /** @var int */
    public const FLOW = 1;

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray() : array
    {
        return [
            [
                'value' => self::MIXED,
                'label' => __('Mixed: SMTP + Flow')
            ],
            [
                'value' => self::FLOW,
                'label' => __('Flow only')
            ]
        ];
    }
}
