<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string|null $title Название статьи
 * @property string|null $img_path Картинка
 * @property string|null $preview Анонс
 * @property string|null $description Текст
 * @property int|null $author_id ID Автора
 *
 * @property Authors $author
 * @property Categories[] $categories
 * @property CategoriesArticles[] $categoriesArticles
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['author_id'], 'integer'],
            [['title', 'img_path'], 'string', 'max' => 255],
            [['preview'], 'string', 'max' => 500],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название статьи',
            'img_path' => 'Картинка',
            'preview' => 'Анонс',
            'description' => 'Текст',
            'author_id' => 'ID Автора',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('categories_articles', ['article_id' => 'id']);
    }

    /**
     * Gets query for [[CategoriesArticles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesArticles()
    {
        return $this->hasMany(CategoriesArticles::class, ['article_id' => 'id']);
    }
}
