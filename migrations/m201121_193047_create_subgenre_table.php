<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subgenre}}`.
 */
class m201121_193047_create_subgenre_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subgenre}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subgenre}}');
    }
}
