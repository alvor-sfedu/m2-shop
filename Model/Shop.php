<?php

namespace Alvor\Shop\Model;

use Magento\Framework\Model\AbstractModel;
use Alvor\Shop\Model\ResourceModel\Shop as ShopResource;

class Shop extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ShopResource::class);
    }
}
