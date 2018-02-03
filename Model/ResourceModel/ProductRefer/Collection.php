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

namespace Abm\ProductRefer\Model\ResourceModel\ProductRefer;

/**
 * Class Collection
 * @package Abm\ProductRefer\Model\ResourceModel\ProductRefer
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'productrefer_id';

    /**
     * Resource initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            'Abm\ProductRefer\Model\ProductRefer',
            'Abm\ProductRefer\Model\ResourceModel\ProductRefer'
        );
    }
}
