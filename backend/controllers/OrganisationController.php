<?php

namespace backend\controllers;

use Yii;
use backend\models\Organisation;
use backend\models\search\OrganisationSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * OrganisationController implements the CRUD actions for Organisation model.
 */
class OrganisationController extends AdminController
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
     * Lists all Organisation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganisationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organisation model.
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
     * Creates a new Organisation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Organisation();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/organisation/".$model->id;
            $this->createEventDirectories($dir);
            $imageName = time();
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!empty($model->file))
            {
                $model->file->saveAs('../../frontend/web/upload/organisation/'.$model->id.'/bg/org_'.$imageName.'.'.$model->file->extension);
                $model->img = 'upload/organisation/'.$model->id.'/bg/org_'.$imageName.'.'.$model->file->extension;
                $model->save();
            }
            $model->fileLogo = UploadedFile::getInstance($model, 'fileLogo');
            if(!empty($model->fileLogo))
            {
                $model->fileLogo->saveAs('../../frontend/web/upload/organisation/'.$model->id.'/logo/org_'.$imageName.'.'.$model->file->extension);
                $model->logo = 'upload/organisation/'.$model->id.'/logo/org_'.$imageName.'.'.$model->file->extension;
                $model->save();
            }
            $model->sliderFiles = UploadedFile::getInstances($model, 'sliderFiles');
            if(!empty($model->sliderFiles)){
                $model->uploadSliderOrg();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    /**
     * Updates an existing Organisation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            //$model->img = "12345";
            //$model->save();
            $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/organisation/".$model->id;
            $this->createEventDirectories($dir);
            $imageName = time();
            $model->file = UploadedFile::getInstance($model, 'file');
            if(!empty($model->file))
            {
                unlink(Yii::getAlias('').'../../frontend/web/'.$model->img);
                $model->file->saveAs('../../frontend/web/upload/organisation/'.$model->id.'/bg/org_'.$imageName.'.'.$model->file->extension);
                $model->img = "upload/organisation/".$model->id."/bg/org_".$imageName.".".$model->file->extension;
                $model->save();
                
                
            }
            $model->fileLogo = UploadedFile::getInstance($model, 'fileLogo');
            if(!empty($model->fileLogo))
            {
                unlink(Yii::getAlias('').'../../frontend/web/'.$model->logo);
                $model->fileLogo->saveAs('../../frontend/web/upload/organisation/'.$model->id.'/logo/org_'.$imageName.'.'.$model->fileLogo->extension);
                $model->logo = "upload/organisation/".$model->id."/logo/org_".$imageName.".".$model->fileLogo->extension;
                $model->save();
                //$model->fileLogo->saveAs('../../frontend/web/upload/organisation/'.$model->id.'/logo/org_'.$imageName.'.'.$model->fileLogo->extension);
            }
            //Загрузка слайдера
            $model->sliderFiles = UploadedFile::getInstances($model, 'sliderFiles');
            if(!empty($model->sliderFiles)){
                $model->uploadSliderOrg();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                /*'values' => $values,*/
            ]);
        }
    }

    /**
     * Deletes an existing Organisation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $dir = $_SERVER['DOCUMENT_ROOT']."/frontend/web/upload/organisation/".$id;
        
        $this->removeDirectory($dir);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function createEventDirectories($dir){
        if (!file_exists($dir)) {
            $dir1 = $dir."/bg";
            $dir2 = $dir."/logo";
            $dir3 = $dir."/slider";
            mkdir($dir, 0777, true);
            mkdir($dir1, 0777, true);
            mkdir($dir2, 0777, true);
            mkdir($dir3, 0777, true);
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
    public function actionDeletelogo($id)
    {
        $model = $this->findModel($id);
        $imgName = '../../frontend/web/'.$model->logo;
        unlink(Yii::getAlias('').$imgName);
        $model->logo = null;
        $model->update();
        if (Yii::$app->request->isAjax)
        {
            return 'Удалено';
        } else {
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }

    /**
     * Finds the Organisation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Organisation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organisation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Померла.');
    }
}
