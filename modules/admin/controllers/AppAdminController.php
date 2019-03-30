<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\components\MessageWriterInterface;
use app\components\HttpDateProviderInterface;

/**
 * Class AppAdminController
 *
 * @package app\modules\admin\controllers
 */
class AppAdminController extends Controller implements MessageWriterInterface, HttpDateProviderInterface{}
