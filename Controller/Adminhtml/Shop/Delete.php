<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderAdminUi\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Saddemlabidi\ShopfinderApi\Api\ShopRepositoryInterface;

class Delete extends Action implements HttpPostActionInterface
{
    public const string ADMIN_RESOURCE = 'Saddemlabidi_Shopfinder::shop';

    public function __construct(
        Context $context,
        private readonly ShopRepositoryInterface $shopRepository
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface|ResponseInterface
    {
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $this->shopRepository->deleteById((int)$id);
                $this->messageManager->addSuccessMessage(__('You deleted the shop.'));
            } catch (NoSuchEntityException|CouldNotDeleteException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
            return $this->_redirect('*/*/');
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a shop to delete.'));
        return $this->_redirect('*/*/');
    }
}
