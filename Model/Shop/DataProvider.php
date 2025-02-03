<?php

declare(strict_types=1);

namespace Saddemlabidi\ShopfinderAdminUi\Model\Shop;

use Magento\Framework\App\Request\DataPersistorInterface;
use Saddemlabidi\Shopfinder\Model\ResourceModel\Shop\CollectionFactory;
use Saddemlabidi\Shopfinder\Model\ResourceModel\Shop\Collection;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    private array $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        public CollectionFactory $collectionFactory,
        public DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    #[\Override] public function getCollection(): Collection
    {
        if (!$this->collection) {
            $this->collection = $this->collectionFactory->create();
        }
        return $this->collection;
    }

    #[\Override] public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $item = $this->collection->getItems();
        foreach ($item as $shop) {
            $this->loadedData[$shop->getId()] = $shop->getData();
        }
        $selectedShop = $this->dataPersistor->get('shopfinder_shop');
        if (!empty($selectedShop->getData())) {
            $this->loadedData[$selectedShop->getId()] = $selectedShop->getData();
            $this->dataPersistor->clear('shopfinder_shop');
        }
        if(empty($this->loadedData)){
            $this->loadedData = [];
        }
        return $this->loadedData;
    }
}
