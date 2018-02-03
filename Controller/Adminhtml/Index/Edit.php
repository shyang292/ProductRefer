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

use Magento\Backend\App\Action;

/**
 * Class Edit
 * @package Abm\ProductRefer\Controller\Adminhtml\Index
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry = null;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Abm\ProductRefer\Model\ProductRefer
     */
    private $referModel;

    /**
     * @var  \Magento\Backend\Model\Session
     */
    private $backSession;

    /**
     * @param \Magento\Backend\App\Action $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Abm\Productrefer\Model\ProductRefer $referModel
     * @param \Magento\Backend\Model\Session $backSession
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Abm\ProductRefer\Model\ProductRefer $referModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->referModel = $referModel;
        $this->backSession = $context->getSession();
        parent::__construct($context);
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abm_ProductRefer::save');
    }

    /**
     * Init actions
     *
     * @return $this
     */
    public function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Abm_ProductRefer::productrefer_manage'
        )->addBreadcrumb(
            __('Refer'),
            __('Refer')
        )->addBreadcrumb(
            __('Manage Refer'),
            __('Manage Refer')
        );
        return $resultPage;
    }

    /**
     * Edit CMS page
     *
     * @return void
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('productrefer_id');
        $model = $this->referModel;

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Reference no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $this->coreRegistry->register('productrefer_id', $model->getId());
        }

        // 3. Set entered data if was error when we do save
        $data = $this->backSession->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        $this->coreRegistry->register('productrefer', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Refer') : __('New Refer'),
            $id ? __('Edit Refer') : __('New Refer')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('ProductReferences'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New References'));
        return $resultPage;
    }
}
