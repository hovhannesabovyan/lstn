<?php

use yii\db\Migration;

/**
 * Class m201126_090647_add_new_column_for_releases_table
 */
class m201126_090647_add_new_column_for_releases_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('tbl_releases','ftp_status',$this->smallInteger()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('tbl_releases','ftp_status');
    }
}
