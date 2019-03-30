<?php

namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use app\models\Category;

/**
 * Class MenuWidget
 * @package app\components
 */
class MenuWidget extends Widget
{
    /**
     * @var array $data Data about category from DB
     */
    public $data = null;

    /**
     * @var array $tree The result of function. Builds a tree array from a common array
     */
    public $tree = null;

    /**
     * @var string $menuHtml Ready to use html-code
     */
    public $menuHtml = null;

    /**
     * @var null $category Category model object
     */
    private $_category = null;

    /**
     * Creating Category object for the further usages
     *
     * @return void
     */
    public function init() :void
    {
        parent::init();
        $this->_category = new Category();
    }

    /**
     * Gets all the necessary data and forms html-menu for widget
     *
     * @return string Html-menu with data set
     */
    public function run() :string
    {
        // Checking, whether widget is cached. If so, getting it from cache
        if(Yii::$app->cache->get('menu')) { return Yii::$app->cache->get('menu'); }

        // All the categories data
        $this->data = $this->_category->getCategoryByIndex();
        // Calling the category data builder
        $this->tree = $this->getTree();

        // Calling the html-menu builder with the built category data set
        $this->menuHtml = $this->getMenuHtml($this->tree);

        // Caching the widget fot 60 seconds(just for a test)
        Yii::$app->cache->set('menu', $this->menuHtml, 60);

        return $this->menuHtml;
    }

    /**
     * Html-tree builder from data array
     *
     * @return array Data set
     */
    public function getTree(): array
    {
        // Category data store
        $tree = [];
        foreach ($this->data as $id => &$node) {
            if($node['parent_id'] == 0) {
                // Marking as a single category
                $tree[$id] = &$node;
            } else {
                $this->data[$node['parent_id']]['children'][$node['id']] = &$node;
            }
        }
        return $tree;
    }

    /**
     * Makes HTML-menu with the data set
     *
     * @param array $tree Category data set
     * @param string $tab indentation
     * @return string Formed html-menu
     */
    public function getMenuHtml(array $tree, string $tab = '') :string
    {

        // Data store
        $str = '';
        foreach ($tree as $category) {
            // Adding the html-menu with the category data set
            $str .= $this->catToTemplate($category, $tab);
        }
        return $str;
    }

    /**
     * @param array $category Category Data set, used within view file
     * @param string $tab indentation, used within view file
     * @return string Widget state
     */
    public function catToTemplate(array $category, string $tab): string
    {
        // Saving the widget state
        ob_start();

        // Including the template

        include 'views/menu.php';

        // Returning the widget state for further surfing
        return ob_get_clean();
    }
}
