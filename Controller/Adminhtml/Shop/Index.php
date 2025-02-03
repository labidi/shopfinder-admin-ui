<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderAdminUi\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    public const string ADMIN_RESOURCE = 'Saddemlabidi_ShopfinderAdminUi::shop';


    public function __construct(
        Action\Context $context,
        private readonly PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Saddemlabidi_ShopfinderAdminUi::shop_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Shop List'));
        return $resultPage;
    }
}
