<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use Yii;

class Event_log extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tbl_event_log';
    }

    public function rules()
    {
        return [
            [['date'], 'string'],
            [['act', 'object'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => Yii::t('app', 'Date'),
            'act' => Yii::t('app', 'Act'),
            'object' => Yii::t('app', 'Object'),
        ];
    }

    public function search($params, $id)
    {
        if ($id) $query = Event_log::find()->where(['id_user' => $id]);
        else $query = Event_log::find()->where(['id_user' => yii::$app->user->identity['id']]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'date', 'act', 'object'
                ],
                'defaultOrder' => [
                    'date' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'act', $this->act])
            ->andFilterWhere(['like', 'object', $this->object]);

        return $dataProvider;

    }
}
