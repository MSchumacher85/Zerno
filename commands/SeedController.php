<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use app\controllers\rest\ArticlesController;
use app\models\Articles;
use app\models\Authors;
use app\models\Categories;
use app\models\CategoriesArticles;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Query;
use yii\db\QueryBuilder;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{
    public function actionAuthor($count = 10)
    {
        $faker = \Faker\Factory::create();

        $authorModel = new Authors();

        for ($i = 1; $i <= $count; $i++) {
            $author = clone $authorModel;
            $author->fio = $faker->lastName . ' ' . $faker->firstName;
            $author->biography = $faker->text(rand(100, 200));
            $author->birthdate = $faker->date();;
            $author->save();
        }
    }

    public function actionArticle($count = 10)
    {
        $faker = \Faker\Factory::create();

        $categoryIds = [];
        if ($categories = Categories::find()->select('categories.id')->
        leftJoin('categories as cc', 'categories.id=cc.parent_id')->andWhere(['is', 'cc.id', new \yii\db\Expression('null')])
            ->all()) {
            foreach ($categories as $category) {
                $categoryIds[] = $category->id;
            }
        }

        $authorIds = [];
        if ($authors = Authors::find()->all()) {
            foreach ($authors as $author) {
                $authorIds[] = $author->id;
            }
        }


        $articlesModel = new Articles();

        for ($i = 1; $i <= $count; $i++) {
            $article = clone $articlesModel;
            $article->title = $faker->title;
            $article->preview = $faker->text(rand(100, 200));
            $article->description = $faker->text(rand(300, 2000));
            $article->author_id = array_rand($authorIds);
            $article->img_path = $faker->imageUrl();;
            $article->save();

            $articlesCategories = new CategoriesArticles();
            $articlesCategories->article_id = $article->id;
            $articlesCategories->category_id = array_rand($categoryIds);
            $articlesCategories->save();
        }
    }

    public function actionCategory($count = 10)
    {
        $faker = \Faker\Factory::create();

        $parentId = [
            0
        ];
        $categoryModel = new Categories();

        for ($i = 1; $i <= $count; $i++) {
            $category = clone $categoryModel;
            $category->category_name = $faker->jobTitle;
            $category->description = $faker->realText(100);
            $category->parent_id = array_rand($parentId);
            $category->save();
            $parentId[] = $category->id;
        }
    }
}
