<?php

namespace app\components;


interface AuthDateProviderInterface
{
    /**
     * @const AUTH_ERROR_MESSAGE Warning message whether validation of login form failed
     */
    public const AUTH_ERROR_MESSAGE = 'Incorrect username or password.';

    /**
     * @const REMEMBER_USER_TIME Time of user accessibility to the system
     */
    public const REMEMBER_USER_TIME = 3600*24*30;
}
