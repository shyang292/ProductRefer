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

interface ProductReferLoaderInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Abm\ProductRefer\Model\ProductRefer
     */
    public function load(RequestInterface $request, ResponseInterface $response);
}
