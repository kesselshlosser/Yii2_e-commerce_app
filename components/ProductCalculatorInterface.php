<?php

namespace app\components;

/**
 * Makes calculations with products prices, quantities and etc.
 *
 * Interface ProductCalculatorInterface
 * @package app\models
 */
interface ProductCalculatorInterface
{
    /**
     * Recalculates the total price of user potential order
     *
     * @param int $id Products identifier
     * @return void
     */
    public function reCalculation(int $id): void;

    /**
     * Gets products quantity
     *
     * @param int $quantity Products quantity
     * @return int Whether quantity hasn't been chosen, it's 1 by default, or user chosen quantity
     */
    public function getProductsQuantity(int $quantity): int;
}
