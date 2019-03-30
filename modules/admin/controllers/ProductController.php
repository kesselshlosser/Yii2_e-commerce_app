<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\controllers\behaviors\TestBehavior;
use app\modules\admin\models\{Category, Product};
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use mihaildev\elfinder\ElFinder;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
final class ProductController extends AppAdminController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            TestBehavior::class,
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index.twig', [
            'dataProvider'    => $dataProvider,
            'productCategory' => $this->setCategoryName(),
            'productIsHit'    => $this->displayProductCriteria('hit'),
            'productIsNew'    => $this->displayProductCriteria('new'),
            'productIsSale'   => $this->displayProductCriteria('sale'),
        ]);
    }

    /**
     * Displays a single Product model.
     *
     * @param integer $id Model identifier
     * @return mixed
     */
    public function actionView(int $id): string
    {
        $getProductImg = function(Product $model): string {
            $img = $model->getImage();

            return "<img src='{$img->getUrl()}'>";
        };

        return $this->render('view.twig', [
            'model'           => $this->findModel($id),
            'productCategory' => $this->setCategoryName(),
            'productImg'      => $getProductImg,
            'productIsHit'    => $this->displayProductCriteria('hit'),
            'productIsNew'    => $this->displayProductCriteria('new'),
            'productIsSale'   => $this->displayProductCriteria('sale'),

        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash(self::FLASH_KEY_SUCCESS, self::FLASH_PRODUCT_UPDATED);
            return $this->redirect(['view', 'id' => $model->id]);
        }
            return $this->render('create.twig', [
                'model'         => $model,
                'categories'    => Category::getCategoryByIndex(),
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */])
            ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id Model identifier
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if($model->image) {
                $model->uploadImage();
            }
            // info_file(/tmp/phpMDA75p): failed to open stream: No such file or directory
            unset($model->image); // There's an error without this string

            $model->collection = UploadedFile::getInstances($model, 'collection');
            $model->uploadImages();
            Yii::$app->session->setFlash(self::FLASH_KEY_SUCCESS, self::FLASH_PRODUCT_UPDATED);

            return $this->redirect(['view', 'id' => $model->id]);
        }
            return $this->render('update.twig', [
                'model'         => $model,
                'categories'    => Category::getCategoryByIndex(),
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */])
            ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id Model identifier
     * @return \yii\web\Response
     */
    public function actionDelete(int $id): \yii\web\Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id Model identifier
     * @return Product the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

            throw new \yii\web\NotFoundHttpException(self::HTTP_EXCEPTION_MESSAGE);
    }
}
