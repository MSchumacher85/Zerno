<?php

namespace app\controllers\rest;

use app\models\Articles;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\rest\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ArticlesController extends \yii\rest\ActiveController
{

    public $modelClass = 'app\models\Articles';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['update'], $actions['create']);

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

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


    public function prepareDataProvider()
    {
        $pageSize = (int)\Yii::$app->request->get('limit') < 10 ? 10 : (int)\Yii::$app->request->get('limit');
        $categoryId = (int)\Yii::$app->request->get('category');

        $query = Articles::find()->joinWith([
            'categories' => function ($query) use ($categoryId) {
                if (!empty($categoryId)) {
                    $query->andWhere(['=', 'categories.id', $categoryId]);
                }
            },
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->asArray(),
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
        ]);


        $query->andFilterWhere(['like', 'articles.title', \Yii::$app->request->get('title')]);
        $query->andFilterWhere(['articles.author_id' => \Yii::$app->request->get('author_id')]);


        return [
            'data' => $dataProvider,
            'meta' => [
                'totalPages' => ceil($dataProvider->getTotalCount() / $pageSize),
                'pageSize' => (int)$pageSize
            ]
        ];
    }
}
