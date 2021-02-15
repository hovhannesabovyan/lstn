<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use \yii\db\Query;

class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number'], 'integer'],
            [['create_date', 'phone', 'status', 'date_complited'], 'safe'],
            [['species_payment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => 'Number',
            'create_date' => 'Created Date',
            'date_complited' => 'Availability Date',
            'phone' => 'Phone',
            'status' => 'Status',
            'payment' => 'Payment',
            'species_payment' => 'Species Payment',
            'total' => 'Total',
        ];
    }

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'number', 'create_date', 'status', 'payment'
                ],
                'defaultOrder' => [
                    'create_date' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'create_date', $this->create_date])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;

    }
}
