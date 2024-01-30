<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%articles}}`.
 */
class m240130_104703_create_articles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->comment('Название статьи'),
            'img_path' => $this->string()->comment('Картинка'),
            'preview' => $this->string(500)->comment('Анонс'),
            'description' => $this->text()->comment('Текст'),
            'author_id' => $this->integer()->comment('ID Автора'),
        ]);

        $this->addForeignKey(
            'fk-articles-author_id',
            '{{%articles}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-articles-author_id','{{%articles}}');
        $this->dropTable('{{%articles}}');
    }
}
