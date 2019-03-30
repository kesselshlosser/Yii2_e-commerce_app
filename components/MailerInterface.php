<?php

namespace app\components;

/**
 * Interface MailerInterface
 * @package app\models
 */
interface MailerInterface
{
    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact(string $email): bool;
}
