<?php

namespace app\components;


/**
 * Gets category by specified type
 *
 * Interface CategorySorterInterface
 * @package app\models
 */
interface CategorySorterInterface
{
    /**
     * Gets category data by its identifier
     *
     * @param int $id Category identifier
     * @return array Single category data
     * @throws \yii\web\HttpException whether a category is not found
     */
    public function getCategoryById(int $id): array;

    /**
     * Gets category data by its index
     *
     * @return array
     */
    public function getCategoryByIndex(): array;
}
