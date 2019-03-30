<?php

namespace app\components;

use app\models\Product;

/**
 * Adds and removes cart items
 *
 * Interface CartManipulator
 * @package app\models
 */
interface CartManipulatorInterface
{
    /**
     * @const CART_TITLE Sets the cart name
     */
    public const CART_TITLE = 'Cart';

    /**
     * @const IMAGE_SIZE Sets image size within cart-modal window
     */
    public const IMAGE_SIZE = 'x50';

    /**
     * Allows adding products and its info to cart
     *
     * @param Product $product A product
     * @param int $quantity Products quantity. By default 1
     * @return void
     */
    public function addToCart(Product $product, int $quantity = 1): void;

    /**
     * Fully cleans the cart
     *
     * @return void
     */
    public function cartCleaning(): void;
}
