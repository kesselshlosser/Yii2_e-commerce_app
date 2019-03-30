<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\components\{CartManipulatorInterface, MailSenderInterface, ProductCalculatorInterface};

/**
 * Class Cart
 *
 * @package app\models
 */
class Cart extends ActiveRecord implements CartManipulatorInterface, MailSenderInterface, ProductCalculatorInterface
{
    /**
     * @var null $_session Session cart data
     */
    private $_session = null;
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * Initializes session cart info
     */
    public function init()
    {
        parent::init();
            $this->_session = [
                'cart'  => &$_SESSION['cart'],
                'total' => &$_SESSION['total']
            ];
    }

    /**
     * Allows adding products and its info to cart
     *
     * {@inheritdoc}
     */
    public function addToCart(Product $product, int $quantity = 1): void
    {
        // Gets products image
        $mainImage = $product->getImage();

        // Checking, whether products are added to cart
        if (isset($this->_session['cart'][$product['id']])) {
            // If so, then increasing the products quantity
            $this->_session['cart'][$product['id']]['quantity'] += $quantity;
        } else {
            // Adding products info to cart
            $this->_session['cart'][$product['id']] = [
                'quantity' => $quantity,
                'name'     => $product['name'],
                'price'    => $product['price'],
                'img'      => $mainImage->getUrl(self::IMAGE_SIZE),
            ];
        }
        // Adding products quantity. Increasing by one or leave previous products quantity value
        $this->_session['total']['quantity'] = isset($this->_session['total']['quantity'])?  $this->_session['total']['quantity'] + $quantity : $quantity;
        // Counting products total price. (Product.price + product.quantity * Product.price). Otherwise (Product.quantity * Product.price)
        $this->_session['total']['sum'] = isset($this->_session['total']['sum'])? $this->_session['total']['sum'] + $quantity * $product['price'] :  $quantity * $product['price'];
    }

    /**
     * Recalculates the total price of user potential order
     *
     * {@inheritdoc}
     */
    public function reCalculation(int $id): void
    {
        // Checking, whether product has already added to cart
        if (isset($this->_session['cart'][$id])) {
            // Assigning the product quantity value
            $decreaseQuantity = $this->_session['cart'][$id]['quantity'];

            // Assigning the product price value (Product.quantity * Product.price)
            $decreaseSum = $this->_session['cart'][$id]['quantity'] * $this->_session['cart'][$id]['price'];

            // Decreasing products quantity
            $this->_session['total']['quantity'] -= $decreaseQuantity;

            // Decreasing products quantity
            $this->_session['total']['sum'] -= $decreaseSum;

            // Removing a product from cart if "X" on cart-modal is pressed
            unset($this->_session['cart'][$id]);
        }
    }

    /**
     * Gets products quantity
     *
     * {@inheritdoc}
     */
    public function getProductsQuantity(int $quantity): int
    {
        // Returning 1, whether quantity value hasn't been set. Otherwise, returning the specified quantity value
        return (!$quantity)? 1 : $quantity;
    }

    /**
     * Cleans cart info
     *
     * {@inheritdoc}
     */
    public function cartCleaning(): void
    {
        Yii::$app->session->remove('cart');
        Yii::$app->session->remove('total');
        Yii::$app->session->close();
    }
}
