<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderAdminUi\Controller\Adminhtml\Shop;

use Magento\Catalog\Controller\Adminhtml\Category\Image\Upload as CategoryImageUpload;

class Upload extends CategoryImageUpload
{
    public const string ADMIN_RESOURCE = 'Saddemlabidi_ShopfinderAdminUi::shop_save';

    protected function _isAllowed() : bool
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }

}
