<?php

namespace Alvor\Shop\Controller\Adminhtml\Shop;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Alvor\Shop\Api\Data\ShopInterface;
use Alvor\Shop\Controller\Adminhtml\Shop;

class Save extends Shop
{
    /**
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        $data = $this->dataProcessor->filter($data);

        if (!$data['entity_id']) {
            $data['entity_id'] = null;
        }

        $shop = $this->initShop();
        $this->dataObjectHelper->populateWithArray($shop, $data, ShopInterface::class);

        if (!$this->dataProcessor->validate($data)) {
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $shop->getEntityId(), '_current' => true]);
        }

        try {
            $this->shopRepository->save($shop);
            $this->messageManager->addSuccessMessage(__('You saved the shop.'));
            $this->dataPersistor->clear('shop_shop');
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $shop->getEntityId(), '_current' => true]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the page.'));
        }

        $this->dataPersistor->set('shop_shop', $data);
        return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
    }
}
