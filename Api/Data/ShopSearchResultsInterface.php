<?php

namespace Alvor\Shop\Api\Data;

interface ShopSearchResultsInterface
{
    /**
     * @return \Alvor\Shop\Api\Data\ShopInterface[]
     */
    public function getItems(): array;

    /**
     * @param \Alvor\Shop\Api\Data\ShopInterface[] $items
     * @return \Alvor\Shop\Api\Data\ShopSearchResultsInterface
     */
    public function setItems(array $items = null): ShopSearchResultsInterface;
}
