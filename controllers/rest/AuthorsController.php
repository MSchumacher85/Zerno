<?php

namespace app\controllers\rest;

use app\models\Articles;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\rest\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AuthorsController extends \yii\rest\ActiveController
{
    
    public $modelClass = 'app\models\Authors';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['update'],$actions['index'], $actions['create']);


        $actions['view']['findModel'] = static function ($id, Action $action) {
            $modelClass = $action->modelClass;
            $model = $modelClass::findOne($id);
            if ($model === null) {
                throw new NotFoundHttpException("Object not found: $id");
            }
            return $model;
        };

        return $actions;
    }

    public function actionView($id)
    {
        return 1;
    }
}
