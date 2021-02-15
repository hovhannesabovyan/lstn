<?php

use yii\db\Migration;

/**
 * Class m201223_200446_add_new_column_in_c_table
 */
class m201223_200446_add_new_column_in_c_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tbl_country','iso',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tbl_country','iso');
    }


}
