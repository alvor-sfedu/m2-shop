<?php

namespace Alvor\Shop\Controller\Adminhtml\Shop;

use Alvor\Shop\Controller\Adminhtml\Shop;

class Edit extends Shop
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $shop = $this->initShop();
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$shop) {
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }
        try {
            $resultPage = $this->initAction();
            $resultPage->getConfig()->getTitle()->prepend(__('Shop'));
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $this->messageManager->addErrorMessage(__('Exception occurred during shop loading'));
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }
        $title = $shop->getEntityId() ? __('Shop "%1"', $shop->getEntityId()) : __('New Shop');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
