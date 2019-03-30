<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Brand;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
final class BrandController extends AppAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Brand models.
     *
     * @return mixed
     */
    public function actionIndex(): string
    {
        $dataProvider =  new ActiveDataProvider([ 'query' => Brand::find()]);

        return $this->render('index.twig', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brand model.
     *
     * @param integer $id Model identifier
     * @return mixed
     */
    public function actionView(int $id): string
    {
        return $this->render('view.twig', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();
        // Checking, whether model has been loaded
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

            return $this->render('create.twig', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id Model identifier
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

            return $this->render('update.twig', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing Brand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id Model identifier
     * @return mixed
     */
    public function actionDelete(int $id): \yii\web\Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id Model identifier
     * @return Brand the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Brand
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }

            throw new \yii\web\NotFoundHttpException(self::HTTP_EXCEPTION_MESSAGE);
    }
}
