<?php

namespace frontend\controllers;

use common\models\ProfileCrud;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\EducationCrud;
use common\models\EducationSearch;
use common\models\Education;
use yii\filters\VerbFilter;


/**
 * ProfileController shows users profiles.
 *
 *
 * @author Henry <alvin_vna@yahoo.com>
 */
class ProfileController extends Controller
{


    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['index','update-profile', 'add-edu', 'update-edu', 'delete-edu', 'educations'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['show'], 'roles' => ['?', '@']],
                ],
            ],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
        			'delete-edu' => ['post'],
				],
			],
        ];
    }

    /**
     * Redirects to current user's profile.
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['show', 'id' => Yii::$app->user->getId()]);
    }

    /**
     * Shows user's profile.
     *
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($id)
    {
        $profile = $this->findProfileByUserId($id);

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'profile' => $profile,
        ]);
    }
    
    public function actionEducations($id)
    {
    	
    	$educations = EducationSearch::searchByUser($id);
    	if (count($educations) <= 0) {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	return $this->render('mainEducations', [
    			'educations' => $educations,
    			'id' => $id
    	]);
    }
    
    public function actionAddEdu($id) {
    	if ($id === null) {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	
    	$model = new EducationCrud();
    	$model->user_id = $id;
    
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		Yii::$app->getSession()->setFlash('success', 'Education have been saved.');
    		return $this->redirect(['educations', 'id' => $id]);
    	}
    	
    	return $this->render('createEducation', [
    			'model' => $model,
    			'id' => $id
    	]);
    }
    
    public function actionUpdateEdu($id) {
    	if (empty($id) && empty($uid)) {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	 
    	$model = Education::findOne($id);
    	$uid = $model->user->id;
    
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		Yii::$app->getSession()->setFlash('success', 'Education have been updated.');
    		$model->refresh();
    		return $this->redirect(['educations', 'id' => $uid]);
    	}
    	 
    	return $this->render('createEducation', [
    			'model' => $model,
    			'id' => $id
    	]);
    }
    
    public function actionDeleteEdu($id)
    {
    	$model = Education::findOne($id);
    	$uid = $model->user->id;
    	
    	$model->delete();
    	Yii::$app->getSession()->setFlash('success', 'Education have been deleted.');
    	return $this->redirect(['educations', 'id'=>$uid]);
    }
    

    /**
     * Updates an existing profile.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdateProfile($id)
    {
        
        $profile    = $this->findProfileByUserId($id);
        
        $this->performAjaxValidation($profile);

        if ($profile->load(Yii::$app->request->post()) && $profile->save()) {
            Yii::$app->getSession()->setFlash('success', 'Profile details have been updated');

            return $this->refresh();
        }

        return $this->render('_formProfile', [
            'profile' => $profile,
        ]);
    }

    /**
     * [findProfileByUserId description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    
    protected function findProfileByUserId($id)
    {
        if (($model = ProfileCrud::find($id)->where(['user_id' => $id])->andWhere(['created_by' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Performs AJAX validation.
     *
     * @param array|Model $model
     *
     * @throws ExitException
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }
        }
    }


}
