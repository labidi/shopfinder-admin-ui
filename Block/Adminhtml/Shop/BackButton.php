<?php

namespace Saddemlabidi\ShopfinderAdminUi\Block\Adminhtml\Shop;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton implements ButtonProviderInterface
{

    public function __construct(public UrlInterface $urlBuilder)
    {
    }

    #[\Override] public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->urlBuilder->getUrl('*/*/')),
            'class' => 'back',
            'sort_order' => 10
        ];
    }
}
