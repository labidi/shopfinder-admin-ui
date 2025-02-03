<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderAdminUi\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class NewAction extends Action
{
    public const string ADMIN_RESOURCE = 'Saddemlabidi_ShopfinderAdminUi::shop';

    public function __construct(
        Action\Context $context,
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface|ResponseInterface|null
    {
        return $this->_forward('edit');
    }

}
