<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $category_name Название
 * @property string|null $description Описание
 * @property int|null $parent_id Связь
 *
 * @property Articles[] $articles
 * @property CategoriesArticles[] $categoriesArticles
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['category_name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Название',
            'description' => 'Описание',
            'parent_id' => 'Связь',
        ];
    }

    /**
     * Gets query for [[Articles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::class, ['id' => 'article_id'])->viaTable('categories_articles', ['category_id' => 'id']);
    }

    /**
     * Gets query for [[CategoriesArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesArticles()
    {
        return $this->hasMany(CategoriesArticles::class, ['category_id' => 'id']);
    }
}
