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

namespace Abm\ProductRefer\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Data
 * @package Abm\ProductRefer\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Path to store config where count of productrefer posts per page is stored
     *
     * @var string
     */
    const XML_PATH_ITEMS_PER_PAGE     = 'productrefer/view/items_per_page';
    
    /**
     * Media path to extension images
     *
     * @var string
     */
    const MEDIA_PATH    = 'productrefer';

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;

    /**
     * File Uploader factory
     *
     * @var \Magento\Core\Model\File\UploaderFactory
     */
    private $fileUploaderFactory;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    private $backendUrl;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->backendUrl = $backendUrl;
        $this->filesystem = $filesystem;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }
    
    /**
     * Upload image and return uploaded image file name or false
     *
     * @throws Mage_Core_Exception
     * @param string $scope the request key for file
     * @return bool|string
     */
    public function uploadFile($scope, $model)
    {
        try {
            $uploader = $this->fileUploaderFactory->create(['fileId' => $scope]);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowCreateFolders(true);
            
            if ($uploader->save($this->getBaseDir())) {
                $model->setFile($uploader->getUploadedFileName());
                $model->setFileExt($uploader->getFileExtension());
            }
        } catch (\Exception $e) {

        }
        
        return $model;
    }
    
    /**
     * Return the base media directory for ProductRefer Item images
     *
     * @return string
     */
    public function getBaseDir()
    {
        $path = $this->filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(self::MEDIA_PATH);
        return $path;
    }
    
    /**
     * Return the Base URL for ProductRefer Item images
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . self::MEDIA_PATH;
    }
    
    /**
     * Return the number of items per page
     *
     * @return int
     */
    public function getProductReferPerPage()
    {
        return abs((int)$this->getScopeConfig()
            ->getValue(self::XML_PATH_ITEMS_PER_PAGE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
        );
    }

    /**
     * Return current store Id
     *
     * @return Int
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    public function getProductsGridUrl()
    {
        return $this->backendUrl->getUrl('productrefer/index/products', ['_current' => true]);
    }

    public function getCategoryGridUrl()
    {
        return $this->_backendUrl->getUrl('productrefer/index/products', ['_current' => true]);
    }
    /**
     * Return customer groups
     */
    public function getCustomerGroup($customers)
    {
        $customers = implode(',', $customers);
        return $customers;
    }

    /**
     * Return category groups
     */
    public function getCcategoryGroup($customers)
    {
        if(isset($customers) && $customers <> ""){
            $customers = implode(',', $customers);
        }else{
            $customers = "";
        }

        return $customers;
    }

    /**
     * Return stores
     */
    public function getStores($store)
    {
        $store = implode(',', $store);
        return $store;
    }
}
