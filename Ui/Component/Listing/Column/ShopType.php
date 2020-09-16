<?php

namespace Alvor\Shop\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;

class ShopType implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => '1', 'label' => __('Always')],
            ['value' => '2', 'label' => __('Hourly')],
            ['value' => '3', 'label' => __('Daily')],
            ['value' => '4', 'label' => __('Weekly')],
            ['value' => '5', 'label' => __('Monthly')],
            ['value' => '6', 'label' => __('Yearly')],
            ['value' => '7', 'label' => __('Never')]
        ];
    }
}
