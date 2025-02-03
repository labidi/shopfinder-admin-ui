<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderAdminUi\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Saddemlabidi\Shopfinder\Model\ShopFactory;
use Saddemlabidi\Shopfinder\Api\ShopRepositoryInterface;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Saddemlabidi_ShopfinderAdminUi::shop';

    public function __construct(
        Action\Context $context,
        private readonly PageFactory $resultPageFactory,
        private readonly ShopFactory $shopFactory,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly ShopRepositoryInterface $shopRepository
    ) {
        parent::__construct($context);
    }

    public function execute(): Page|ResponseInterface
    {
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            $shop = $this->shopRepository->getById((int)$id);
            if (!$shop->getId()) {
                $this->messageManager->addErrorMessage(__('This shop no longer exists.'));
                return $this->_redirect('*/*/index');
            }
        }else {
            $shop = $this->shopFactory->create();
        }
        $this->dataPersistor->set('shopfinder_shop', $shop);
        $resultPage = $this->resultPageFactory->create();
        $title = $id ? __('Edit Shop') : __('New Shop');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
