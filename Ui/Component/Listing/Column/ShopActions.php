<?php

namespace Alvor\Shop\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class ShopActions extends Column
{
    const SHOP_URL_PATH_EDIT = 'shop/shop/edit';
    const SHOP_URL_PATH_DELETE = 'shop/shop/delete';

    private $urlBuilder;

    private $editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        string $editUrl = self::SHOP_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name]['edit'] = [
                        'href'  => $this->urlBuilder->getUrl($this->editUrl, ['entity_id' => $item['entity_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href'    => $this->urlBuilder
                            ->getUrl(self::SHOP_URL_PATH_DELETE, ['entity_id' => $item['entity_id']]),
                        'label'   => __('Delete'),
                        'confirm' => [
                            'title'   => __('Delete ${ $.$data.name }'),
                            'message' => __('Are you sure you want to delete a ${ $.$data.name } record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
