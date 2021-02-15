<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\QueryInterface;
use Yii;

class Users extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'email'],
            [['username', 'role'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'User Name'),
            'role' => Yii::t('app', 'Role'),
            'email' => Yii::t('app', 'E-mail'),
        ];
    }

    /**
     * @inheritdoc
     */

    public function search($params)
    {
        $query = (new \yii\db\Query())
            ->select('tbl_users.id, tbl_users.block, tbl_users.username, tbl_users.email, tbl_role.role')
            ->from('tbl_users')
            ->innerJoin('tbl_role', 'tbl_role.id = tbl_users.role')
            ->where('tbl_users.cabinet ="' . yii::$app->user->identity['cabinet'] . '" AND tbl_users.id !=' . yii::$app->user->identity['id'])
            ->andWhere(['del' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'username', 'email', 'role'
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'tbl_users.username', $this->username])
            ->andFilterWhere(['like', 'tbl_role.role', $this->role])
            ->andFilterWhere(['like', 'tbl_users.email', $this->email]);

        return $dataProvider;

    }

    public function search_black($params)
    {
        $query = (new \yii\db\Query())
            ->select('tbl_users.id, tbl_users.block, tbl_users.username, tbl_users.email, tbl_role.role')
            ->from('tbl_users')
            ->innerJoin('tbl_role', 'tbl_role.id = tbl_users.role')
            ->where('tbl_users.cabinet ="' . yii::$app->user->identity['cabinet'] . '" AND tbl_users.id !=' . yii::$app->user->identity['id'])
            ->andWhere(['del' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'username', 'email', 'role'
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'tbl_users.username', $this->username])
            ->andFilterWhere(['like', 'tbl_role.role', $this->role])
            ->andFilterWhere(['like', 'tbl_users.email', $this->email]);

        return $dataProvider;

    }
}
