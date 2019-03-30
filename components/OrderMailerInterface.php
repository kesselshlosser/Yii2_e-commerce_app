<?php

namespace app\components;

use yii\web\Session;

/**
 * Interface OrderMailerInterface
 *
 * @package app\models
 */
interface OrderMailerInterface
{
    /**
     * Sends user order to their email address
     *
     * @param Session $params Order info
     * @param array $letterOptions User email info
     * @return void The result of saving
     */
    public function sendOrderToMail(Session $params, array $letterOptions): void;
}
