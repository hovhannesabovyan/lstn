<?php

use yii\db\Migration;

/**
 * Class m201210_130347_add_new_column_in_genre_and_subgenre
 */
class m201210_130347_add_new_column_in_genre_and_subgenre extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('genre','name_en',$this->string());
        $this->addColumn('subgenre','name_en',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('','name_en');
        $this->dropColumn('subgenre','name_en');
    }


}
