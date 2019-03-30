<?php

namespace app\controllers;

use Yii;
use app\models\{Category, Product};
use yii\data\Pagination;
use yii\web\HttpException;

/**
 * Class CategoryController
 *
 * @package app\controllers
 */
final class CategoryController extends AppController
{
    /**
     * @var Product|null Setting Product object
     */
    private $_product = null;
    /**
     * @var Category|null Setting Category object
     */
    private $_category = null;

    /**
     * Creating Product and Category objects for further usages
     *
     * @return void
     */
    public function init():void
    {
        parent::init();
        $this->_product = new Product();
        $this->_category = new Category();
    }

    /**
     * Used to set the rules before actions run
     *
     * @param string $action Name of an action
     * @return bool true Whether method is considered to be executed
     */
    public function beforeAction($action): bool
    {
        if ($this->action->id == 'index') {
            // Disabling csrf validation for actionIndex
            Yii::$app->controller->enableCsrfValidation = false;
        }

        return true;
    }

    /**
     * Passes all the necessary data to the main page
     *
     * @return string Data set
     */
    public function actionIndex(): string
    {
        // TODO: Ajax refreshing

        //Setting main page title
        $this->setMeta($this->_category::META_TITLE);

        return $this->render('index.twig', [
            //Getting hit products
            'hits'            => $this->_product->getHitProducts(),
            // Getting brand products (IS NOT USED)
            'brands'          => $this->_product->getBrandProducts(),
            // Getting sale products
            'sales'           => $this->_product->getSaleProducts(),
            // Getting all the products types
            'types'           => $this->_product->getProductsType(),
            // Getting a product by its type
            'typed'           => $this->_product->getProductByType(),
            // Minimal price for price range widget
            'productMinValue' => $this->_category::PRODUCT_MIN_VALUE,
            // Maximal price for price range widget
            'productMaxValue' => $this->_category::PRODUCT_MAX_VALUE,
            // Chosen price value on widget(just for test)
            'asd'             =>  Yii::$app->request->post('price_range'),
        ]);
    }

    /**
     * Provides all the necessary data to a product view
     *
     * @param int $id Product identifier
     * @return string Data set
     * @throws HttpException whether a category has not been found
     */
    public function actionView(int $id): string
    {
        // Getting a category by its identifier
        $category = $this->_category->getCategoryById($id);

        // Getting products by its category
        $query = $this->_product->getProductByCategory($id);

        // Creating pagination functionality
        $pages = new Pagination(['totalCount'     => $query->count(),
                                 'pageSize'       => $this->_category::PRODUCT_PER_PAGE,
                                 'forcePageParam' => false,
                                 'pageSizeParam'  => false
        ]);

        // Data offset
        $products = $this->_product->productsPageOffset($query, $pages->offset, $pages->limit);

        // Setting page title and meta info depending on a category
        $this->setMeta($this->_category::META_TITLE.$category['name'], $category['keywords'], $category['description']);

        return $this->render('view.twig', [
            'products' => $products,
            'pages'    => $pages,
            'category' => $category,
        ]);
    }

    /**
     * AJAX products search by the request
     *
     * @return null|void
     */
    public function actionSearch(): void
    {
        // Checking whether get request is search
        if(Yii::$app->request->get('search') == '' || empty(Yii::$app->request->get('search'))) {
            echo 'No suggestion';
            return;
        }
        $request = trim(Yii::$app->request->get('search'));

        //Looking for a product
        $products = $this->_product->findProduct($request);

        if(!empty($products)) {
            // Displaying all the found products
            foreach ($products as $product) {
                echo "<a href='/product/{$product['id']}'>{$product['name']}</a>";
            }
        } else { // Whether product wasn't found
            echo 'No suggestion';
        }
    }
}
