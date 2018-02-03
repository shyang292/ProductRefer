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

namespace Abm\ProductRefer\Controller\Adminhtml\Index;

/**
 * Class MassDelete
 * @package Abm\ProductRefer\Controller\Adminhtml\Index
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    private $filter;

    /** 
     * @var \Abm\ProductRefer\Model\ResourceModel\ProductRefer\CollectionFactory
     */
    private $collectionFactory;
    
    /**
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Abm\ProductRefer\Model\ResourceModel\ProductRefer\CollectionFactory $collectionFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Abm\ProductRefer\Model\ResourceModel\ProductRefer\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $logCollection = $this->filter->getCollection($this->collectionFactory->create());

            $itemsDeleted = 0;
            foreach ($logCollection as $item) {
                $item->delete();
                $itemsDeleted++;
            }
            $this->messageManager->addSuccess(__('A total of %1 FAQ(s) were deleted.', $itemsDeleted));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('productrefer/index');
    }
}
