<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderAdminUi\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\Page;
use Saddemlabidi\Shopfinder\Api\ShopRepositoryInterface;
use Saddemlabidi\Shopfinder\Model\ShopFactory;

class Save extends Action
{
    public const string ADMIN_RESOURCE = 'Saddemlabidi_ShopfinderAdminUi::shop_save';

    public function __construct(
        public Action\Context $context,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly ShopFactory $shopFactory,
        private readonly ShopRepositoryInterface $shopRepository
    ) {
        parent::__construct($context);
    }

    #[\Override] public function execute(): Page|ResponseInterface
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $this->_redirect('*/*/index');
        }
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            $shop = $this->shopRepository->getById((int)$id);
            if ($id != $shop->getId()) {
                $this->messageManager->addErrorMessage(__('This shop no longer exists.'));
                return $this->_redirect('*/*/');
            }
        } else {
            $shop = $this->shopFactory->create();
        }
        if (empty($data['entity_id'])) {
            $data['entity_id'] = null;
        }
        $shop->setData($data);
        try {
            $this->shopRepository->save($shop);
            $this->messageManager->addSuccessMessage(__('You saved the shop.'));
            $this->dataPersistor->clear('shopfinder_shop');
            if ($this->getRequest()->getParam('back')) {
                return $this->_redirect('*/*/edit', ['shop_id' => $shop->getId(), '_current' => true]);
            }
            return $this->_redirect('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the shop.'));
        }
        return $this->_redirect('*/*/');
    }
}
