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

namespace Abm\ProductRefer\Block\Adminhtml\ProductRefer\Edit\Tab;

use Abm\ProductRefer\Model\ProductReferFactory;

/**
 * Class Products
 * @package Abm\ProductRefer\Model\ProductReferFactory
 */
class Products extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var \Abm\ProductRefer\Model\ProductRefer
     */
    private $referModel;
    
    /**
     * Contact factory
     *
     * @var ContactFactory
     */
    private $contactFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Registry $registry
     * @param \Abm\ProductRefer\Model\ProductReferFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Abm\ProductRefer\Model\ProductRefer $referModel
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $registry,
        ProductreferFactory $contactFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Abm\ProductRefer\Model\ProductRefer $referModel,
        array $data = []
    ) {
        $this->contactFactory = $contactFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->registry = $registry;
        $this->referModel = $referModel;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * _construct
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('productsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('productrefer_id')) {
            $this->setDefaultFilter(['in_product' => 1]);
        }
    }

    /**
     * add column filter to collection
     */
    public function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_product') {
            $productIds = $this->_getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * prepare collection
     */
    public function _prepareCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('price');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    public function _prepareColumns()
    {

        $model = $this->referModel;

        $this->addColumn(
            'in_product',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_product',
                'align' => 'center',
                'index' => 'entity_id',
                'values' => $this->_getSelectedProducts(),
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header' => __('Product ID'),
                'type' => 'number',
                'index' => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'names',
            [
                'header' => __('Name'),
                'index' => 'name',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('Sku'),
                'index' => 'sku',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'currency',
                'index' => 'price',
                'width' => '50px',
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/productsgrid', ['_current' => true]);
    }

    /**
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    public function _getSelectedProducts()
    {
        $contact = $this->getContact();
        return $contact->getProducts($contact);
    }

    /**
     * Retrieve selected products
     *
     * @return array
     */
    public function getSelectedProducts()
    {
        $contact = $this->getContact();
        $selected = $contact->getProducts($contact);
        
        if (!is_array($selected)) {
            $selected = [];
        }
        return $selected;
    }

    public function getContact()
    {
        $contactId = $this->getRequest()->getParam('productrefer_id');
        $contact   = $this->contactFactory->create();
        if ($contactId) {
            $contact->load($contactId);
        }
        return $contact;
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return true;
    }
}
