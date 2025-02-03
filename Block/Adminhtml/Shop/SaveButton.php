<?php

namespace Saddemlabidi\ShopfinderAdminUi\Block\Adminhtml\Shop;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton implements ButtonProviderInterface
{

    #[\Override] public function getButtonData()
    {
        return [
            'label' => __('Save Shop'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 10
        ];
    }

}
