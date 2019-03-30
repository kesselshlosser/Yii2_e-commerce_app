<?php

namespace app\components;

/**
 * Interface MessengerInterface
 *
 * @package app\models
 */
interface MessengerInterface extends MessageWriterInterface
{
    /**
     * Displays the massage of successfully order made
     *
     * @param string $key Message key
     * @param string $value Message text
     * @return null|string Message
     */
    public function showSuccessMessage(string $key, string $value): ?string;

    /**
     * Displays the message of failed order made
     *
     * @param string $key Message key
     * @param string $value Message text
     * @return null|string Message
     */
    public function showErrorMessage(string $key, string $value): ?string;
}
