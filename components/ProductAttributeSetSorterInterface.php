<?php

namespace app\components;

/**
 * Interface ProductAttributeSetSorterInterface Provides a set of constants for product manipulations
 *
 * @package app\models
 */
interface ProductAttributeSetSorterInterface extends MetaProviderInterface
{
    /**
     * @const PRODUCT_STATUS_TRUE Status of a product
     */
    public const PRODUCT_STATUS_TRUE = '1';
    /**
     * @const PRODUCT_STATUS_FALSE Status of a product
     */
    public const PRODUCT_STATUS_FALSE = '0';
    /**
     * @const PRODUCT_COUNT Default value of products per page
     */
    public const PRODUCT_COUNT = 6;
    /**
     * @const MIN_PRODUCT_PRICE The minimum price value for products
     */
    public const MIN_PRODUCT_PRICE = 0;
    /**
     * @const MAX_PRODUCT_PRICE The maximum price value for products
     */
    public const MAX_PRODUCT_PRICE = 600;
}
