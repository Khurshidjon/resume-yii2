<?php

namespace backend\controllers;

use backend\models\Model;
use backend\models\ModelWork;
use common\models\Educations;
use common\models\Works;
use Yii;
use common\models\Persons;
use backend\models\search\PersonsSearch;
use yii\base\Response;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use kartik\mpdf\Pdf;


/**
 * PersonController implements the CRUD actions for Persons model.
 */
class PersonController extends Controller
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
     * Lists all Persons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Persons model.
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
     * Creates a new Persons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Persons();
	    $modelsEducations = [new Educations()];
	    $modelsWorks = [new Works()];

        if ($model->load(Yii::$app->request->post())) {

	        $model->avatar = UploadedFile::getInstance($model, 'avatar');

	        if ($model->validate()) {
		        $model->avatar->saveAs('uploads/' . $model->avatar->baseName . '.' . $model->avatar->extension);
	        }

	        $model->save(false);

//	        $modelsEducations = $model->load($modelsEducations);
	        $modelClass = Model::createMultiple(Educations::classname()); //@Educations::class();
	        $modelClassWork = ModelWork::createMultiple(Works::classname()); //@Works::class();

	        Model::loadMultiple($modelClass, Yii::$app->request->post());
	        ModelWork::loadMultiple($modelClassWork, Yii::$app->request->post());

	        // validate all models
	        $valid = $model->validate();

	        $valid1 = Model::validateMultiple($modelClass) && $valid;
	        $valid2 = ModelWork::validateMultiple($modelClassWork) && $valid;

	        if ($valid1 or $valid2) {
		        $transaction = \Yii::$app->db->beginTransaction();
		        try {
			        if ($flag1 = $model->save(false)) {
				        foreach ($modelClass as $modelC) {
					        $modelC->person_id = $model->id;
					        if (! ($flag1 = $modelC->save(false))) {
						        $transaction->rollBack();
						        break;
					        }
				        }
				        foreach ($modelClassWork as $modelW) {
					        $modelW->person_id = $model->id;
					        if (! ($flag2 = $modelW->save(false))) {
						        $transaction->rollBack();
						        break;
					        }
				        }
			        }
			        if ($flag1 and $flag2) {
				        $transaction->commit();
				        return $this->redirect(['view', 'id' => $model->id]);
			        }
		        } catch (\Exception $e) {
			        $transaction->rollBack();
		        }
	        }
        }

        return $this->render('create', [
            'model' => $model,
	        'modelsEducations' => (empty($modelsEducations)) ? [new Educations()] : $modelsEducations,
	        'modelsWorks' => (empty($modelsWorks)) ? [new Works()] : $modelsWorks
        ]);
    }

    /**
     * Updates an existing Persons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
	    $model = $this->findModel($id);
	    $modelsWorks = $model->works;
	    $modelsEducation = $model->education;

	    if ($model->load(Yii::$app->request->post())) {

		    $oldIDWorks = ArrayHelper::map($model, 'id', 'id');
		    $modelWorks = ModelWork::createMultiple(Works::classname(), $modelsWorks);
		    $modelEducation = Model::createMultiple(Educations::classname(), $modelsEducation);

		    $image = UploadedFile::getInstance($model, 'avatar');

		    $oldImage = $model->avatar;

		    if(isset($image)){
			    $model->avatar =  $image->baseName . '.' . $image->extension;
			    $image->saveAs('uploads/' . $image->baseName . '.' .$image->extension);
		    } else {
			    $model->avatar = $oldImage;
		    }

		    $model->update(false);

		    ModelWork::loadMultiple($modelsWorks, Yii::$app->request->post());
		    Model::loadMultiple($modelsEducation, Yii::$app->request->post());

		    $deletedIDworks = array_diff($oldIDWorks, array_filter(ArrayHelper::map($model, 'id', 'id')));
		    $deletedIDeducation = array_diff($oldIDWorks, array_filter(ArrayHelper::map($model, 'id', 'id')));

		    // ajax validation
		    if (Yii::$app->request->isAjax) {
			    Yii::$app->response->format = Response::FORMAT_JSON;
			    return ArrayHelper::merge(
				    ActiveForm::validateMultiple($modelWorks),
				    ActiveForm::validateMultiple($modelEducation),
				    ActiveForm::validate($model)
			    );
		    }

		    // validate all models
		    $valid = $model->validate();
		    $validWork = ModelWork::validateMultiple($modelWorks) && $valid;
		    $validEdu = Model::validateMultiple($modelEducation) && $valid;

		    if ($validWork OR $validEdu) {
			    $transaction = \Yii::$app->db->beginTransaction();
			    try {
				    if ($flag = $model->save(false)) {
					    if (! empty($deletedIDworks)) {
						    Works::deleteAll(['id' => $deletedIDworks]);
						    Educations::deleteAll(['id' => $deletedIDeducation]);
					    }
					    foreach ($modelWorks as $modelWork) {
						    $modelWork->person_id = $model->id;
						    if (! ($flag1 = $modelWork->save(false))) {
							    $transaction->rollBack();
							    break;
						    }
					    }

					    foreach ($modelEducation as $education) {
						    $education->person_id = $model->id;
						    if (! ($flag2 = $education->save(false))) {
							    $transaction->rollBack();
							    break;
						    }
					    }
				    }
				    if ($flag1 and $flag2) {
					    $transaction->commit();
					    return $this->redirect(['view', 'id' => $model->id]);
				    }
			    } catch (Exception $e) {
				    $transaction->rollBack();
			    }
		    }
	    }
        return $this->render('update', [
            'model' => $model,
	        'modelsWorks' => (empty($modelsWorks)) ? [new Works()] : $modelsWorks,
	        'modelsEducations' => (empty($modelsEducation)) ? [new Educations()] : $modelsEducation
        ]);
    }

    /**
     * Deletes an existing Persons model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Persons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Persons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Persons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


	public function actionViewPrivacy($id) {
    	$model = $this->findModel($id);
		Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		$pdf = new Pdf([
			'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
			'destination' => Pdf::DEST_BROWSER,
			'content' => $this->renderPartial('resumePdf', [
				'model' => $model,
			]),
			'options' => [
				// any mpdf options you wish to set
			],
			'methods' => [
				'SetTitle' => 'Resume - target.uz',
				'SetSubject' => 'target.uz',
				'SetHeader' => ['Resume - target.uz: ' . date("d.m.Y")],
				'SetFooter' => ['|Page {PAGENO}|'],
				'SetAuthor' => 'target.uz',
				'SetCreator' => 'target.uz',
				'SetKeywords' => 'target.uz, Resume Export, PDF, Privacy, Policy',
			]
		]);
		return $pdf->render();
	}



}
