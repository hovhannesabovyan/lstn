<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use \yii\db\Query;

class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rank'], 'integer'],
            [['name'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'square_id' => 'Square id',
            'name' => 'Title',
            'is_deleted' => 'Published',
            'rank' => 'Ranking',
            'image' => 'Picture',
        ];
    }

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'name', 'rank'
                ],
                'defaultOrder' => [
                    'rank' => SORT_ASC
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['rank' => $this->rank])
            ->andFilterWhere(['is_deleted' => $this->is_deleted]);

        return $dataProvider;

    }
}
