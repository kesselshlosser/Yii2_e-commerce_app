<?php

namespace app\components;

/**
 * Provides email options
 *
 * Interface MailSenderInterface
 * @package app\models
 */
interface MailSenderInterface
{
    /**
     * @const ADDRESS_MASK Sets the address mask
     */
    public const ADDRESS_MASK = 'Yii2.loc';

    /**
     * MAIL_SUBJECT Sets the order subject before mailing
     */
    public const MAIL_SUBJECT = 'Order';
}
