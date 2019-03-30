<?php

namespace app\modules\admin\controllers;


final class SiteController extends AppAdminController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
