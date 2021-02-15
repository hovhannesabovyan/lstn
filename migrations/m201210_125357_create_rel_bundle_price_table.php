<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rel_bundle_price}}`.
 */
class m201210_125357_create_rel_bundle_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rel_bundle_price}}', [
            'id' => $this->primaryKey(),
            'sum' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rel_bundle_price}}');
    }
}
