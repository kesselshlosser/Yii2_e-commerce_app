<?php

namespace app\components;

/**
 * Interface OrderSaverInterface
 *
 * @package app\models
 */
interface OrderSaverInterface
{
    /**
     * Saves data about made order
     *
     * @param array $items Ordered products and their info
     * @param int $order_id Order identifier
     * @return void
     */
    public function saveOrderItems(array $items, int $order_id): void;
}
