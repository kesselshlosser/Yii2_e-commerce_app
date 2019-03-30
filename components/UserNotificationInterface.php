<?php

namespace app\components;


/**
 * Interface UserNotificationInterface
 *
 * @package app\components
 */
interface UserNotificationInterface
{
    /**
     *
     * @return mixed
     */
    public function getEmail(): string;

    /**
     *
     * @return mixed
     */
    public function getSubject(): string;
}
