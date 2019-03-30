<?php

namespace app\components;

/**
 * Provides a set of get product data
 *
 * Interface ProductDateProviderInterface
 * @package app\models
 */
interface ProductDateProviderInterface
{
    /**
     * @const PRODUCT_PER_PAGE Number of products per page
     */
    const PRODUCT_PER_PAGE = 3;
    /**
     * @const PRODUCT_MIN_VALUE Min price value for product
     */
    const PRODUCT_MIN_VALUE = 0;
    /**
     *@const PRODUCT_MAX_VALUE Max price value for product
     */
    const PRODUCT_MAX_VALUE = 600;
}
