<?php

namespace backend\controllers;

use Yii;
use backend\models\Event;
use backend\models\search\EventSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends AdminController
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
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
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
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/event/".$model->id;
            $this->createEventDirectories($dir);
            $imageName = time();
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!empty($model->file))
            {
                $model->file->saveAs('../../frontend/web/upload/event/'.$model->id.'/bg/events_'.$imageName.'.'.$model->file->extension);
                $model->picture = 'upload/event/'.$model->id.'/bg/events_'.$imageName.'.'.$model->file->extension;
                $model->save();
            }
            $model->sliderFiles = UploadedFile::getInstances($model, 'sliderFiles');
            if(!empty($model->sliderFiles)){
                $model->uploadSlider();
            }
            if (!$model->uploadSlider()) {
                // file is uploaded dont successfully
                //return $this->redirect(['view', 'id' => $model->id]);;
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $imageName = time();
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!empty($model->file))
            {
                $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/event/".$model->id;
                $this->createEventDirectories($dir);
                unlink(Yii::getAlias('').'../../frontend/web/'.$model->picture);
                $model->file->saveAs('../../frontend/web/upload/event/'.$model->id.'/bg/events_'.$imageName.'.'.$model->file->extension);
                $model->picture = 'upload/event/'.$model->id.'/bg/events_'.$imageName.'.'.$model->file->extension;
                $model->save();
            }
            $model->sliderFiles = UploadedFile::getInstances($model, 'sliderFiles');
            if(!empty($model->sliderFiles)){
                $model->uploadSlider();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/event/".$model->id;
        $this->removeDirectory($dir);
        $model->delete();

        return $this->redirect(['index']);
    }

    //метод для удаления изображения без перезагрузки
    public function actionDeleteimage($id)
    {
        $model = $this->findModel($id);
        $imgName = '../../frontend/web/'.$model->picture;
        unlink(Yii::getAlias('').$imgName);
        $model->picture = null;
        $model->update();
        if (Yii::$app->request->isAjax)
        {
            return 'Удалено';
        } else {
            return $this->redirect(['update', 'id' => $model->id]);
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

    protected function createEventDirectories($dir){
        if (!file_exists($dir)) {
            $dir1 = $dir."/bg";
            $dir2 = $dir."/slider";
            mkdir($dir, 0777, true);
            mkdir($dir1, 0777, true);
            mkdir($dir2, 0777, true);
        }
    }


    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Померала дак померла');
    }
}
