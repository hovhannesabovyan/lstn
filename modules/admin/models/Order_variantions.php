<?php


namespace app\modules\admin\models;

use yii\db\ActiveRecord;

class Order_variantions extends ActiveRecord
{
    public static function tableName()
    {
        return 'tbl_order_variantions';
    }
}
