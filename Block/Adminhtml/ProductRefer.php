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

namespace Abm\ProductRefer\Block\Adminhtml;

/**
 * Class ProductRefer
 * @package Abm\ProductRefer\Block\Adminhtml
 */
class ProductRefer extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    public function _construct()
    {
        $this->_controller = 'adminhtml_productRefer';
        $this->_blockGroup = 'Abm_ProductRefer';
        $this->_headerText = __('Product References');
        $this->_addButtonLabel = __('Add New References');
        parent::_construct();
        if ($this->_isAllowedAction('Abm_ProductRefer::save')) {
            $this->buttonList->update('add', 'label', __('Add New References'));
        } else {
            $this->buttonList->remove('add');
        }
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    public function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}