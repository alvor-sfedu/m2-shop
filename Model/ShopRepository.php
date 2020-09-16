<?php

namespace Alvor\Shop\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Alvor\Shop\Api\Data\ShopInterface;
use Alvor\Shop\Api\Data\ShopInterfaceFactory;
use Alvor\Shop\Model\ResourceModel\Shop as ShopResource;
use Alvor\Shop\Model\ResourceModel\Shop\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchResultsInterface;

class ShopRepository implements \Alvor\Shop\Api\ShopRepositoryInterface
{
    private $shopFactory;
    private $shopResource;
    private $shopDataFactory;
    private $dataObjectHelper;
    private $collectionFactory;
    private $collectionProcessor;
    private $searchResultsFactory;
    private $extensibleDataObjectConverter;


    public function __construct(
        ShopFactory $objectFactory,
        ShopResource $shopResource,
        ShopInterfaceFactory $shopDataFactory,
        DataObjectHelper $dataObjectHelper,
        CollectionFactory $collectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->shopFactory = $objectFactory;
        $this->shopResource = $shopResource;
        $this->shopDataFactory = $shopDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param ShopInterface $shop
     * @return ShopInterface
     * @throws CouldNotSaveException
     */
    public function save(ShopInterface $shop)
    {
        try {
            $shopData = $this->extensibleDataObjectConverter->toNestedArray($shop, [], ShopInterface::class);
            $shopModel = $this->shopFactory->create(['data' => $shopData])
                ->setDataChanges(true);
            $this->shopResource->save($shopModel);
            $shop->setEntityId($shopModel->getId());
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $shop;
    }

    /**
     * @param int $id
     * @return ShopInterface
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $shop = $this->shopFactory->create();
        $this->shopResource->load($shop, $id);
        if (!$shop->getId()) {
            throw new NoSuchEntityException(__('Object with id "%1" does not exist.', $id));
        }
        $dataObject = $this->shopDataFactory->create();
        $this->dataObjectHelper->populateWithArray($dataObject, $shop->getData(), ShopInterface::class);
        return $dataObject;
    }


    /**
     * @param ShopInterface $dataObject
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ShopInterface $dataObject)
    {
        try {
            $shop = $this->shopFactory->create();
            $shop->setId($dataObject->getEntityId());
            $this->shopResource->delete($shop);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
