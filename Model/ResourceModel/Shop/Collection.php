<?php

namespace Alvor\Shop\Model\ResourceModel\Shop;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Alvor\Shop\Model\ResourceModel\Shop as ShopResource;
use Alvor\Shop\Model\Data\Shop;
use Alvor\Shop\Api\Data\ShopInterface;


class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(Shop::class, ShopResource::class);
    }
}



