<?php
namespace Alvor\Shop\Api;

use Alvor\Shop\Api\Data\ShopInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Alvor\Shop\Api\Data\ShopSearchResultsInterface;

interface ShopRepositoryInterface
{
    /**
     * @param ShopInterface $feed
     * @return ShopInterface
     */
    public function save(ShopInterface $feed);

    /**
     * @param int $id
     * @return ShopInterface
     */
    public function getById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ShopSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param ShopInterface $feed
     * @return bool
     */
    public function delete(ShopInterface $feed);
}
