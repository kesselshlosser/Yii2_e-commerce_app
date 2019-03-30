<?php

namespace app\components;

/**
 * Interface MessageWriterInterface provides a set of order making constants, depending on an order status
 * @package app\models
 */
interface MessageWriterInterface
{
    /**
     * @const FLASH_KEY_SUCCESS message about successful order making
     */
    public const FLASH_KEY_SUCCESS  = 'success';
    /**
     * @const FLASH_KEY_SUCCESS Successful order message
     */
    public const FLASH_MESSAGE_SUCCESS  = 'Your order is accepted. Our manager will contact with you as soon as possible';
    /**
     * @const FLASH_KEY_SUCCESS message about failed order making
     */
    public const FLASH_KEY_ERROR  = 'error';
    /**
     * @const FLASH_KEY_SUCCESS Failed order message
     */
    public const FLASH_MESSAGE_ERROR  = 'Something is wrong with your order. Please, try again';

    /**
     * @const FLASH_PRODUCT_UPDATED Message for flash messages
     */
    public const FLASH_PRODUCT_UPDATED = 'Product was successfully updated';
}
