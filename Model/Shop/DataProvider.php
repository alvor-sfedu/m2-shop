<?php

namespace Alvor\Shop\Model\Shop;

use Alvor\Shop\Api\Data\ShopInterface;
use Alvor\Shop\Model\ResourceModel\Shop\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $pageCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $pageCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $this->loadedData = [];
        foreach ($items as $shop) {
            $this->loadedData[$shop->getId()] = $this->processType($shop->getData());
        }

        $data = $this->dataPersistor->get('shop_shop');
        if (!empty($data)) {
            $shop = $this->collection->getNewEmptyItem();
            $shop->setData($data);
            $this->loadedData[$shop->getId()] = $shop->getData();
            $this->dataPersistor->clear('shop_shop');
        }
        return $this->loadedData;
    }

    private function processType(array $data): array
    {
        $data[ShopInterface::TYPE] = explode(',', $data[ShopInterface::TYPE]);
        return $data;
    }

}
