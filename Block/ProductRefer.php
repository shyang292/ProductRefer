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

namespace Abm\ProductRefer\Block;

/**
 * Class Refer
 * @package Abm\ProductRefer\Block
 */
class ProductRefer extends \Magento\Framework\View\Element\Template
{
    /**
     * ProductRefer collection
     *
     * @var Abm\ProductRefer\Model\ResourceModel\ProductRefer\Collection
     */
    private $productreferCollection = null;
    
    /**
     * ProductRefer factory
     *
     * @var Abm\ProductRefer\Model\ProductReferFactory
     */
    private $productreferCollectionFactory;
    
    /**
     * @var Abm\ProductRefer\Helper\Data
     */
    private $dataHelper;

    /**
     * @var Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Magento\Framework\Registry
     */
    private $registry;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Abm\ProductRefer\Model\ResourceModel\ProductRefer\CollectionFactory $productreferCollectionFactory
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     * @param \Abm\ProductRefer\Helper\Data $dataHelper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Abm\ProductRefer\Model\ResourceModel\ProductRefer\CollectionFactory $productreferCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Abm\ProductRefer\Helper\Data $dataHelper,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->customerSession =$customerSession;
        $this->productreferCollectionFactory = $productreferCollectionFactory;
        $this->objectManager = $objectmanager;
        $this->dataHelper = $dataHelper;
        $this->scopeConfig = $context->getScopeConfig();
        $this->registry = $registry;
        parent::__construct(
            $context,
            $data
        );
    }
    
    /**
     * Check module is enable or not
     */
    public function isEnable()
    {
        return $this->getConfig('productrefer/general/enable');
    }

    /**
     * Retrieve productrefer collection
     *
     * @return Abm\ProductRefer\Model\ResourceModel\ProductRefer\Collection
     */
    public function getCollection()
    {
        $collection = $this->productreferCollectionFactory->create();
        return $collection;
    }
    
    /**
     * Filter productrefer collection by product Id
     *
     * @return collection
     */
    public function getRefer()
    {
        $categoryIds = $this->getCurrentCategoryIds();
        $sku = $this->getCurrentSku();
        $sku = "[[:<:]]".$sku."[[:>:]]";
        $categoryIdsStr = '';
        foreach ($categoryIds as $cat){
            $categoryIdsStr.= "[[:<:]]".$cat."[[:>:]]|";
        }
        $categoryIdsStr = substr($categoryIdsStr,0,-1);//remove the last |
        $collection = $this->getCollection();
        $collection->getSelect()->where("products REGEXP '$sku' OR category_group REGEXP '$categoryIdsStr'");
        return $collection;
    }


    /**
     * Return getCategory groups
     */
    public function getCategoryGroup($categorires)
    {
        $categories = implode(',', $categorires);
        return $categories;
    }

    /**
     * Retrive refer url by refer
     *
     * @return string
     */
    public function getReferUrl($refer)
    {
        $url = $this->dataHelper->getBaseUrl().'/'.$refer;
        return $url;
    }

    /**
     * Retrive current product id
     *
     * @return number
     */
    public function getCurrentId()
    {
        $product = $this->registry->registry('current_product');
        return $product->getId();
    }

    /**
     * tony add
     * @return mixed
     */
    public function getCurrentCategoryIds()
    {
        $product = $this->registry->registry('current_product');
        return $product->getCategoryIds();
    }

    /**
     * Retrive current customer id
     *
     * @return number
     */
    public function getCustomerId()
    {
        $customerId = $this->customerSession->getCustomer()->getGroupId();
        return $customerId;
    }


    /**
     * Retrive config value
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue(
            $config,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrive Tab Name
     */
    public function getTabName()
    {
        $tabName = __($this->getConfig('productrefer/general/tabname'));
        return $tabName;
    }
}
