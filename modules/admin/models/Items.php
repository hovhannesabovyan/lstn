<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use \yii\db\Query;
use app\modules\admin\models\Tax;
use app\modules\admin\models\Category;

class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_items';
    }

    //public $image;

    /*public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }*/

    /**
     * @inheritdoc
     */

    public function getTax()
    {
        return $this->hasOne(Tax::className(), ['id' => 'tax_ids']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function rules()
    {
        return [

            [['id', 'category_id'], 'integer'],
            [['name'], 'safe'],
            [['name', 'square_id'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'square_id' => 'Square id',
            'name' => 'Title',
            'is_deleted' => 'Published',
            'category_id' => 'Category',
            'tax_ids' => 'Tax',
            'image' => 'Picture',
            'description' => 'Description',
            'related_items' => 'Related products'
        ];
    }

    public function search($params)
    {
        $query = self::find();
        if (isset($params['Items']['category_id'])) {
            if ($params['Items']['category_id']) {
                $id_cat = Category::find()->select('id')->where('name like ("%' . $params['Items']['category_id'] . '%")')->asArray()->one();
                if ($id_cat) $params['Items']['category_id'] = $id_cat['id'];
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'name', 'category_id', 'tax_ids', 'is_deleted'
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'square_id', $this->square_id])
            ->andFilterWhere(['category_id' => $this->category_id])
            ->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['is_deleted' => $this->is_deleted]);

        return $dataProvider;
    }

    public function upload($id)
    {
        if ($this->validate()) {
            $path = 'image/items/' . $id . '/' . $this->image->baseName . '.' . $this->image->extension;
            $this->image->saveAs($path);
            $this->image->tempName = $path;
            return true;
        } else {
            return false;
        }
    }
}
