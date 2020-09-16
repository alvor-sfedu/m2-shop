<?php

namespace Alvor\Shop\Controller\Adminhtml\Shop;

use Alvor\Shop\Controller\Adminhtml\Shop;

class Delete extends Shop
{
    /**
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $shop = $this->initShop();
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$shop || !$shop->getEntityId()) {
            $this->messageManager->addErrorMessage(__('We can\'t find a shop to delete.'));
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $this->shopRepository->delete($shop);
            $this->messageManager->addSuccessMessage(__('The shop has been deleted.'));
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $shop->getEntityId()]);
        }
    }
}
