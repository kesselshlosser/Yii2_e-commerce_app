<?php

namespace app\controllers;

use Yii;
use app\models\{Cart, Product, Order};

/**
 * Class CartController
 *
 * @package app\controllers
 */
final class CartController extends AppController
{
    /**
     * For Cart object
     *
     * @var Cart|null
     */
    private $_cart = null;
    /**
     * For Product object
     *
     * @var Product|null
     */
    private $_product = null;
    /**
     * For Order object
     *
     * @var Order|null
     */
    private $_order = null;
    /**
     * For session manipulations
     *
     * @var mixed|null|\yii\web\Session
     */
    private $_session = null;

    /**
     * Creating all the necessary objects for further usages
     *
     */
    public function init()
    {
        parent::init();
        $this->_cart = new Cart();
        $this->_product = new Product();
        $this->_order = new Order();

        // Checking, whether session is opened
        if(!Yii::$app->session->isActive) {
            $this->_session = Yii::$app->session;
            $this->_session->open();
        } else {
            $this->_session = Yii::$app->session;
        }
    }

    /**
     * Implementation of a product adding to cart
     *
     * @param int $id A product identifier
     * @return bool|string|\yii\web\Response
     */
    public function actionAdd(int $id)
    {
        // Getting quantity of a chosen product
        $quantity = (int)Yii::$app->request->get('quantity');

        // Getting products quantity from cart
        $quantity =  $this->_cart->getProductsQuantity($quantity);

        //Getting product by its identifier
        $product = $this->_product->getProductById($id);

        // Adding product to cart with chosen quantity
        $this->_cart->addToCart($product, $quantity);

        // Checking whether request is AJAX. If so, then redirecting user on a previous page
        if(!Yii::$app->request->isAjax) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        // Disabling the site layout(header, footer and etc.)
        $this->layout = false;

        return $this->render('cart-modal.twig', [
            'session' => $this->_session,
        ]);
    }

    /**
     * Cleans cart data rendering null values
     *
     * @return string Data set
     */
    public function actionClear(): string
    {
        // Disabling the site layout in modal window
        $this->layout = false;

        return $this->render('cart-modal.twig', [
            'session' => $this->_cart->cartCleaning(),
        ]);
    }

    /**
     * Removes a product from cart
     *
     * @param int $id Product's identifier
     * @return string Data set
     */
    public function actionRemoveItem(int $id): string
    {
        // Recalculating order total price
        $this->_cart->reCalculation($id);

        // Disabling the site layout in modal window
        $this->layout = false;

        return $this->render('cart-modal.twig', [
            'session' => $this->_session,
        ]);
    }

    /**
     * Displays cart-modal window
     *
     * @return string Data set
     */
    public function actionShow(): string
    {
        // Disabling the site layout in modal window
        $this->layout = false;

        return $this->render('cart-modal.twig', [
            'session' => $this->_session,
        ]);
    }

    /**
     * Handles an order
     *
     * @return string|\yii\web\Response
     */
    public function actionView()
    {
        //Setting main page title
        $this->setMeta($this->_cart::CART_TITLE);

        //Whether order form has been loaded
        if($this->_order->load(Yii::$app->request->post())) {
            // Getting product quantity from session
            $this->_order->quantity = $this->_session['total']['quantity'];

            // // Getting the total price of products from session
            $this->_order->sum = $this->_session['total']['sum'];

            // Whether order is successfully
            if($this->_order->save()) {
                // Saving order data
                $this->_order->saveOrderItems($this->_session['cart'], $this->_order->id);

                // Displaying the message about successful order
                $this->_order->showSuccessMessage();

                // Sending the order data from admin to user, who made an order
                $this->_order->sendOrderToMail($this->_session, [
                    'sender'   => Yii::$app->params['adminEmail'],
                    'mask'     => $this->_cart::ADDRESS_MASK,
                    'receiver' => $this->_order->email,
                    'subject'  => $this->_cart::MAIL_SUBJECT
                ]);

                // Cleaning user cart after successful order
                $this->_cart->cartCleaning();

                // Reloading a page
                return $this->refresh();
            } else {
                // Displaying a message about failed order
                $this->_order->showErrorMessage();
            }
        }

        return $this->render('view.twig', [
            'session' => $this->_session,
            'order'   => $this->_order,
        ]);
    }
}
