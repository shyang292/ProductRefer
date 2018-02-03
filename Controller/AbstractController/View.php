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

namespace Abm\ProductRefer\Controller\AbstractController;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 * @package Abm\ProductRefer\Controller\AbstractController
 */
abstract class View extends Action\Action
{
    /**
     * @var \Abm\ProductRefer\Controller\AbstractController\ProductReferLoaderInterface
     */
    private $productreferLoader;
    
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param OrderLoaderInterface $orderLoader
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        ProductReferLoaderInterface $productreferLoader,
        PageFactory $resultPageFactory
    ) {
        $this->productreferLoader = $productreferLoader;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * ProductRefer view page
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->productreferLoader->load($this->_request, $this->_response)) {
            return;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
