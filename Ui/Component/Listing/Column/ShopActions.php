<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderAdminUi\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ShopActions extends Column
{
    public const URL_PATH_EDIT = 'shopfinder/shop/edit';
    public const URL_PATH_DELETE = 'shopfinder/shop/delete';

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        public UrlInterface $urlBuilder,
        public Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['entity_id'])) {
                    $shopName = $this->escaper->escapeHtmlAttr($item['name']);
                    $item[$this->getData('name')] = [
                        "edit" => [
                            'href' => $this->urlBuilder->getUrl($this::URL_PATH_EDIT, ['entity_id' => $item['entity_id']]),
                            'label' => __('Edit')
                        ],
                        "delete" => [
                            'href' => $this->urlBuilder->getUrl($this::URL_PATH_DELETE, ['entity_id' => $item['entity_id']]),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete %1',$shopName),
                                'message' => __('Are you sure you wan\'t to delete the %1 shop?', $shopName),
                            ],
                            'post' => true
                        ],
                    ];
                }
            }
        }
        return $dataSource;
    }
}
