<?php

namespace app\modules\admin\controllers\behaviors;

use Yii;
use yii\base\Behavior;
use app\modules\admin\controllers\CategoryController;
use app\modules\admin\controllers\OrderController;
use app\modules\admin\controllers\ProductController;

/**
 * Class TestBehavior
 * @package app\modules\admin\controllers\behaviors
 */
class TestBehavior extends Behavior
{
    /**
     * @return array
     */
    public function events()
    {
       return [
           CategoryController::EVENT_AFTER_ACTION => 'setCategoryName',
           OrderController::EVENT_AFTER_ACTION    => 'getOrderStatus',
           ProductController::EVENT_AFTER_ACTION  => 'displayProductCriteria',
       ];
    }

    /**
     * Sets category name or makes it as single
     *
     * @return \Closure
     */
    public function setCategoryName(): \Closure
    {
        return function ($model) {
            return (isset($model->category->name)) ? $model->category->name : 'Single category';
        };
    }

    /**
     * Sets style for displaying order status depending on its value
     *
     * @return \Closure
     */
    public function getOrderStatus(): \Closure
    {
        return function($model) {
            return (!$model->status)? '<span class="text-danger">Closed</span>': '<span class="text-success">Active</span>';
        };
    }

    /**
     * Sets style for displaying product criteria(hit, new, sale) depending on its value
     *
     * @param string $criteria Product criteria
     * @return \Closure
     */
    public function displayProductCriteria($criteria): \Closure
    {
         // TODO: make an Exception here
        return function ($model) use($criteria)  {
            return (!$model->$criteria)? '<span class="text-danger">No</span>': '<span class="text-success">Yes</span>';
        };
    }
}
