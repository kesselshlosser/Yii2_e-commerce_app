<?php

namespace app\components;

use app\models\Product;

/**
 * Interface ProductSorterInterface
 *
 * @package app\components
 */
interface ProductSorterInterface extends ProductAttributeSetSorterInterface
{

    /**
     * Gets the number of hit products
     *
     * @param array $hits Hit products
     * @return int The number of hit products
     */
    public function getProductsNumber(array $hits): int;

    /**
     * Looks for products by their name symbols
     *
     * @param string $param A part of product name
     * @return array Product data set
     */
    public function findProduct(string $param): array;

    /**
     * Gets product by its identifier
     *
     * @param int $id Product identifier
     * @return Product Product data set
     * @throws \yii\web\HttpException Whether product with specified id is not found
     */
    public function getProductById(int $id): Product;

    /**
     * Gets all the products types
     *
     * @return mixed Data set
     */
    public function getProductsType();
}