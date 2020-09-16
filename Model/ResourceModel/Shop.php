<?php

namespace Alvor\Shop\Model\ResourceModel;

use Alvor\Shop\Api\Data\ShopInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Shop extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('shop', 'entity_id');
    }

    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object): Shop
    {
        $object->setData(ShopInterface::TYPE, implode(',', $object->getData(ShopInterface::TYPE)));
        return parent::_beforeSave($object);
    }

}
