<?php

/**
 * Mageprince
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @package Abm_ProductRefer
 */

namespace Abm\ProductRefer\Block\Adminhtml\ProductRefer;

/**
 * Class Grid
 * @package Abm\ProductRefer\Block\Adminhtml\ProductRefer
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Abm\ProductRefer\Model\ResourceModel\ProductRefer\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Abm\ProductRefer\Model\ProductRefer
     */
    private $productrefer;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Abm\ProductRefer\Model\ProductRefer $productreferPage
     * @param \Abm\ProductRefer\Model\ResourceModel\Productrefer\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Abm\ProductRefer\Model\ProductRefer $productrefer,
        \Abm\ProductRefer\Model\ResourceModel\ProductRefer\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->productrefer = $productrefer;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('productReferGrid');
        $this->setDefaultSort('productrefer_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    public function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    public function _prepareColumns()
    {
        $this->addColumn('productrefer_id', [
            'header'    => __('ID'),
            'index'     => 'productrefer_id',
        ]);
        
        $this->addColumn(
            'name',
            [
                'header' => __('Question'),
                'index' => 'name'
            ]
        );

        $this->addColumn(
            'description',
            [
                'header' => __('Answer'),
                'index' => 'description'
            ]
        );

        $this->addColumn(
            'file',
            [
                'header' => __('file'),
                'index' => 'file'
            ]
        );

        $this->addColumn(
            'file_ext',
            [
                'header' => __('file_ext'),
                'index' => 'file_ext'
            ]
        );

        
        $this->addColumn(
            'customer_group',
            [
                'header' => __('Customer Group'),
                'index' => 'customer_group',
                'renderer' => 'Abm\ProductRefer\Block\Adminhtml\ProductRefer\Renderer\Group'
            ]
        );

        $this->addColumn(
            'store',
            [
                'header' => __('Store '),
                'index' => 'store',
                'renderer' => 'Abm\ProductRefer\Block\Adminhtml\ProductRefer\Renderer\Store'
            ]
        );

        $this->addColumn(
            'active',
            [
                'header' => __('Active'),
                'index' => 'active',
                'renderer' => 'Abm\ProductRefer\Block\Adminhtml\ProductRefer\Renderer\Active'
            ]
        );
       
        $this->addColumn(
            'action',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'class' => 'action-secondary',
                        'url' => [
                            'base' => '*/*/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'productrefer_id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'css_class' => 'scalable action-secondary',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return false;
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
