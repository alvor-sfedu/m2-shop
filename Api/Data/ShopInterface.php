<?php
namespace Alvor\Shop\Api\Data;
use Alvor\Shop\Model\Data\Shop;
use Magento\Framework\Api\ExtensibleDataInterface;

interface ShopInterface extends ExtensibleDataInterface
{
    const TYPE = 'type';
    const TEXT = 'text';
    const ENTITY_ID = 'entity_id';

    /**
     * @return string|array
     */
    public function getType();

    /**
     * @param string|array $type
     * @return Shop
     */
    public function setType($type): Shop;

    /**
     * @return string
     */
    public function getText();

    /**
     * @param string $text
     * @return Shop
     */
    public function setText(string $text): Shop;

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $entityId
     * @return Shop
     */
    public function setEntityId(int $entityId): Shop;
}
