<?php

namespace app\controllers;


use app\models\User;

class TestController extends AppController
{
    public function actionIndex()
    {
        $user = new User();
        echo '<br>test';
    }
}