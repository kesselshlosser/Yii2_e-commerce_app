<?php
namespace app\controllers;

use yii\web\Controller;

/**
 * Class AppController
 * @package app\controllers
 */
class AppController extends Controller
{
    /**
     * Registers all the meta data
     *
     * @param string|null $title Title name
     * @param string|null $keywords Meta data
     * @param string|null $description Meta data description
     */
    protected function setMeta(string $title = null, string $keywords = null, string $description = null) :void
    {
        // Setting a title name
        $this->view->title = $title;

        // Registering meta data
        $this->view->registerMetaTag(['name' => 'keywords',    'content' => "$keywords"]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => "$description"]);
    }
}
