<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\controllers\behaviors\TestBehavior;
use app\modules\admin\models\Category;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
final class CategoryController extends AppAdminController
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
     * Lists all Category models.
     *
     * @return mixed
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()->with('category'),
        ]);

        return $this->render('index.twig', [
            'dataProvider'   => $dataProvider,
            'parentCategory' => $this->setCategoryName(),
        ]);
    }

    /**
     * Displays a single Category model.
     *
     * @param integer $id Model identifier
     * @return mixed
     */
    public function actionView(int $id): string
    {
        return $this->render('view.twig', [
            'model'          => $this->findModel($id),
            'parentCategory' => $this->setCategoryName(),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash(self::FLASH_KEY_SUCCESS, "Category {$model->name} is successfully created");

            return $this->redirect(['view', 'id' => $model->id]);
        }

            return $this->render('create.twig', [
                'model'      => $model,
                'categories' => Category::getCategoryByIndex(),
            ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id Model identifier
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

            return $this->render('update.twig', [
                'model'      => $model,
                'categories' => Category::getCategoryByIndex(),
            ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id Model identifier
     * @return \yii\web\Response
     *
     */
    public function actionDelete(string $id): \yii\web\Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id Model identifier
     * @return Category the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

            throw new \yii\web\NotFoundHttpException(self::HTTP_EXCEPTION_MESSAGE);
    }
}
