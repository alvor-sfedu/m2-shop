<?php

namespace Alvor\Shop\Model\Data;

use Magento\Framework\Model\AbstractModel;
use Alvor\Shop\Api\Data\ShopInterface;
use Alvor\Shop\Model\ResourceModel\Shop as ShopResource;

class Shop extends AbstractModel implements ShopInterface
{
    public function _construct()
    {
        $this->_init(ShopResource::class);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return explode(',', $this->getData(ShopInterface::TYPE));
    }

    /**
     * @param string $type
     * @return Shop
     */
    public function setType($type): Shop
    {
        if (is_array($type)) {
            $type = implode(',', $type);
        }
        return $this->setData(ShopInterface::TYPE, $type);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->getData(ShopInterface::TEXT);
    }

    /**
     * @param string $text
     * @return Shop
     */
    public function setText(string $text): Shop
    {
        return $this->setData(ShopInterface::TEXT, $text);
    }

    /**
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(ShopInterface::ENTITY_ID);
    }

    /**
     * @param int $entityId
     * @return mixed
     */
    public function setEntityId($entityId): Shop
    {
        return $this->setData(ShopInterface::ENTITY_ID, $entityId);
    }
}
