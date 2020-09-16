<?php

namespace Alvor\Shop\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InputException;
use Alvor\Shop\Api\Data\ShopInterfaceFactory;
use Alvor\Shop\Api\ShopRepositoryInterface;
use Psr\Log\LoggerInterface;

abstract class Shop extends Action
{
    const ADMIN_RESOURCE = 'Alvor_Shop::shop';

    protected $_publicActions = ['view', 'index'];

    protected $coreRegistry = null;
    protected $resultPageFactory;
    protected $resultJsonFactory;
    protected $resultLayoutFactory;
    protected $resultForwardFactory;
    protected $shopRepository;
    protected $shopDataFactory;
    protected $logger;
    protected $dataProcessor;
    protected $dataPersistor;
    protected $dataObjectHelper;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        ShopRepositoryInterface $shopRepository,
        ShopInterfaceFactory $shopDataFactory,
        LoggerInterface $logger,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->shopRepository = $shopRepository;
        $this->shopDataFactory = $shopDataFactory;
        $this->logger = $logger;
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context);
    }

    protected function initAction(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Alvor_Shop::shop');
        $resultPage->addBreadcrumb(__('Alvor'), __('Alvor'));
        $resultPage->addBreadcrumb(__('Shop'), __('Shop'));
        return $resultPage;
    }

    /**
     * @return \Alvor\Shop\Api\Data\ShopInterface|false
     */
    protected function initShop()
    {
        $id = $this->getRequest()->getParam('entity_id');
        try {
            $shop = $id ? $this->shopRepository->getById($id) : $this->shopDataFactory->create();
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This shop no longer exists.'));
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            return false;
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage(__('This shop no longer exists.'));
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        return $shop;
    }

}
