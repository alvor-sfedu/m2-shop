<?php

namespace Alvor\Shop\Block\Adminhtml\Shop\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\RequestInterface ;
use Alvor\Shop\Api\Data\ShopInterface;

class GenericButton
{
    protected $context;
    protected $request;

    public function __construct(
        Context $context,
        RequestInterface $request
    ) {
        $this->context = $context;
        $this->request = $request;
    }

    /**
     * @return int|null
     */
    public function getShopId()
    {
        return $this->request->getParam(ShopInterface::ENTITY_ID);
    }

    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
