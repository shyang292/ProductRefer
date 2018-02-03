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

namespace Abm\ProductRefer\Block\Adminhtml\ProductRefer\Edit;

/**
 * Class Tabs
 * @package Abm\ProductRefer\Block\Adminhtml\ProductRefer\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('References Information'));
    }
}
