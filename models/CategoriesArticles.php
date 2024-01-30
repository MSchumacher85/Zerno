<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories_articles".
 *
 * @property int $category_id ID категории
 * @property int $article_id ID Статьи
 *
 * @property Articles $article
 * @property Categories $category
 */
class CategoriesArticles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories_articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'article_id'], 'required'],
            [['category_id', 'article_id'], 'integer'],
            [['category_id', 'article_id'], 'unique', 'targetAttribute' => ['category_id', 'article_id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::class, 'targetAttribute' => ['article_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'ID категории',
            'article_id' => 'ID Статьи',
        ];
    }

    /**
     * Gets query for [[Article]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::class, ['id' => 'article_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }
}
