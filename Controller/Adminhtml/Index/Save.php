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
use Abm\ProductRefer\Helper\Data;

/**
 * Class Save
 * @package Abm\ProductRefer\Controller\Adminhtml\Index
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PostDataProcessor
     */
    private $dataProcessor;

    /**
     * @var \Abm\ProductRefer\Helper\Data
     */
    private $helper;

    /**
     * @var \Abm\ProductRefer\Model\ProductRefer
     */
    private $referModel;

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $backSession;

    /**
     * @param \Magento\Backend\App\Action $context
     * @param PostDataProcessor $dataProcessor
     * @param \Abm\ProductRefer\Model\ProductRefer $referModel
     * @param \Magento\Backend\Model\Session $backSession
     * @param \Abm\ProductRefer\Helper\Data $data
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        \Abm\ProductRefer\Model\ProductRefer $referModel,
        Data $helper
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->referModel = $referModel;
        $this->backSession = $context->getSession();
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abm_ProductRefer::save');
    }

    /**
     * Save action
     *
     * @return void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
//            print_r($data);die();
            $data = $this->dataProcessor->filter($data);
            //$customerGroup = $this->helper->getCustomerGroup($data['customer_group']);
            $categoryGroup = $this->helper->getCcategoryGroup((isset($data['category_group'])?$data['category_group']:"")); /*tony add*/
            //$store = $this->helper->getStores($data['store']);
            //$data['customer_group'] = $customerGroup;
            $data['category_group'] = $categoryGroup; /*tony add*/
            //$data['store'] = $store;

            $model = $this->referModel;
            $id = $this->getRequest()->getParam('productrefer_id');
            
            if ($id) {
                $model->load($id);
            }
            
            $model->addData($data);

            if (!$this->dataProcessor->validate($data)) {
                $this->_redirect('*/*/edit', ['productrefer_id' => $model->getId(), '_current' => true]);
                return;
            }

            try {
                $model->save();
                $this->messageManager->addSuccess(__('Reference has been saved.'));
                $this->backSession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['productrefer_id' => $model->getId(), '_current' => true]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the references.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['productrefer_id' => $this->getRequest()->getParam('productrefer_id')]);
            return;
        }
        $this->_redirect('*/*/');
    }
}
