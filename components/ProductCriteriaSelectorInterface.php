<?php

namespace app\components;

use yii\db\ActiveQuery;

/**
 * Interface ProductCriteriaSelectorInterface Selects product by its criteria
 * @package app\models
 */
interface ProductCriteriaSelectorInterface extends ProductAttributeSetSorterInterface
{
    /**
     * Gets the only hit products
     *
     * @param int $minPrice The minimum price value
     * @param int $maxPrice The maximum price value
     * @return array Hit products data
     */
    public function getHitProducts(int $minPrice, int $maxPrice): array;

    /**
     * Gets the only brand products
     *
     * @return array Brand products data
     */
    public function getBrandProducts(): array;

    /**
     * Gets the only hit products
     *
     * @return array Sale products data
     */
    public function getSaleProducts(): array;

    /**
     * Gets products by their category
     *
     * @param int $id Product identifier
     * @return ActiveQuery Product data set
     */
    public function getProductByCategory(int $id): ActiveQuery;

    /**
     * Gets products by their brand
     *
     * @param int $id Product identifier
     * @return ActiveQuery Product data set
     */
    public function getProductByBrand(int $id): ActiveQuery;

    /**
     * Gets products by their types
     *
     * @return mixed Product data set
     */
    public function getProductByType();
}
