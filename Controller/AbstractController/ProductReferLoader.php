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

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

/**
 * Class ProductReferLoader
 * @package Abm\ProductRefer\Controller\AbstractController
 */
class ProductReferLoader implements ProductReferLoaderInterface
{
    /**
     * @var \Abm\ProductRefer\Model\ProductReferFactory
     */
    private $productreferFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;

    /**
     * @param \Abm\ProductRefer\Model\ProductReferFactory $productreferFactory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Abm\ProductRefer\Model\ProductReferFactory $productreferFactory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->productreferFactory = $productreferFactory;
        $this->registry = $registry;
        $this->url = $url;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return bool
     */
    public function load(RequestInterface $request, ResponseInterface $response)
    {
        $id = (int)$request->getParam('id');
        if (!$id) {
            $request->initForward();
            $request->setActionName('noroute');
            $request->setDispatched(false);
            return false;
        }

        $productrefer = $this->productreferFactory->create()->load($id);
        $this->registry->register('current_productrefer', $productrefer);
        return true;
    }
}
