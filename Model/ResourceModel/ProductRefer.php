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

namespace Abm\ProductRefer\Model\ResourceModel;

/**
 * Class ProductRefer
 * @package Abm\ProductRefer\Model\ResourceModel
 */
class ProductRefer extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('abm_productrefer', 'productrefer_id');
    }
}
