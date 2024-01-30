<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m240130_104705_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'category_name' => $this->string()->comment('Название'),
            'description' => $this->string()->comment('Описание'),
            'parent_id' => $this->integer()->comment('Связь')->defaultValue(null)
        ]);

        $this->createIndex(
            'idx-categories-parent_id',
            '{{%categories}}',
            'parent_id'
        );

        $this->createTable('{{%categories_articles}}', [
            'category_id' => $this->integer()->comment('ID категории'),
            'article_id' => $this->integer()->comment('ID Статьи'),
            'PRIMARY KEY(category_id, article_id)',
        ]);

        $this->addForeignKey(
            'fk-categories_articles-article_id',
            '{{%categories_articles}}',
            'article_id',
            '{{%articles}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-categories_articles-category_id',
            '{{%categories_articles}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-categories_articles-article_id','{{%categories_articles}}');
        $this->dropForeignKey('fk-categories_articles-category_id','{{%categories_articles}}');
        $this->dropIndex('idx-categories-parent_id','{{%categories}}');
        $this->dropTable('{{%categories_articles}}');
        $this->dropTable('{{%categories}}');
    }
}
