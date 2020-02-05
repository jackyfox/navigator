<?php

namespace backend\controllers;

use Yii;
use backend\models\Profession;
use backend\models\search\ProfessionSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProfessionController implements the CRUD actions for Profession model.
 */
class ProfessionController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profession models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfessionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profession model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Profession model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profession();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/profession/".$model->id;
            $this->createEventDirectories($dir);
            $imageName = time();
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!empty($model->file))
            {
                $model->file->saveAs('../../frontend/web/upload/profession/'.$model->id.'/bg/org_'.$imageName.'.'.$model->file->extension);
                $model->img = 'upload/profession/'.$model->id.'/bg/org_'.$imageName.'.'.$model->file->extension;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Profession model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/profession/".$model->id;
            $this->createEventDirectories($dir);
            $imageName = time();
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!empty($model->file))
            {
                unlink(Yii::getAlias('').'../../frontend/web/'.$model->img);
                $model->file->saveAs('../../frontend/web/upload/profession/'.$model->id.'/bg/org_'.$imageName.'.'.$model->file->extension);
                $model->img = 'upload/profession/'.$model->id.'/bg/org_'.$imageName.'.'.$model->file->extension;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Profession model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/profession/".$id;
        $this->removeDirectory($dir);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profession model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profession the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profession::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function createEventDirectories($dir){
        if (!file_exists($dir)) {
            $dir1 = $dir."/bg";
            $dir2 = $dir."/slider";
            mkdir($dir, 0777, true);
            mkdir($dir1, 0777, true);
            mkdir($dir2, 0777, true);
        }
    }
    protected function removeDirectory($dir) {
        if ($objs = glob($dir."/*")) {
           foreach($objs as $obj) {
                is_dir($obj) ? $this->removeDirectory($obj) : unlink($obj);
           }
        }
        rmdir($dir);
    }
    
    //метод для удаления изображения без перезагрузки
    public function actionDeleteimage($id)
    {
        $model = $this->findModel($id);
        $imgName = '../../frontend/web/'.$model->img;
        unlink(Yii::getAlias('').$imgName);
        $model->img = null;
        $model->update();
        if (Yii::$app->request->isAjax)
        {
            return 'Удалено';
        } else {
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }
}
