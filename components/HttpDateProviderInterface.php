<?php

namespace app\components;

/**
 * Provides a set of HTTP data for exceptions
 *
 * Interface HttpDateProviderInterface
 * @package app\models
 */
interface HttpDateProviderInterface
{
    /**
     * @const HTTP_ITEM_IS_NOT_FOUND Error message whether an item wasn't found
     */
    public const HTTP_ITEM_IS_NOT_FOUND = 'The requested Item could not be found.';

    /**
     * @const HTTP_EXCEPTION_MESSAGE Error message whether a category wasn't found
     */
    public const HTTP_EXCEPTION_MESSAGE = 'The requested page does not exist.';

    /**
     * @const HTTP_EXCEPTION_STATUS HTTP status code
     */
    public const HTTP_EXCEPTION_STATUS = 404;
}
