<?php


namespace app\models;


use app\components\Common;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\Json;

class Track_release extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_track_releases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['track_artist', 'track_title', 'mix_name'], 'string', 'max' => 255],
            [['track'], 'file', 'extensions' => 'flac,wav,mp3'],
            [['track', 'track_title', 'track_price'], 'required'],
            ['track_price', 'safe'],
            ['track_price', 'double'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'track' => Yii::t('app', 'Track'),
            'track_artist' => Yii::t('app', 'Track Artist'),
            'track_title' => Yii::t('app', 'Track Title'),
            'mix_name' => Yii::t('app', 'Mix Name'),
            'track_price' => Yii::t('app', 'Track Price')
        ];
    }

    public static function DataTracks()
    {
        return [
            '20' => 20,
            '200' => 200,
            '20.3' => 20.3,
            '55.7' => 55.7,
        ];
    }

    public function getReleases()
    {
        return $this->hasOne(Releases::className(), ['id' => 'releases_id']);
    }

    public function upload($id)
    {
        if ($this->validate()) {
            $path = 'image/releases/' . $id . '/tracks/' . $this->track->baseName . '.' . $this->track->extension;
            $this->track->saveAs($path);
            $this->track->tempName = $path;
            $data = Json::decode(Common::CheckTrack($path));

            if (empty($data['ok'])){

                Yii::$app->session->setFlash('error', Yii::t('app','You need to remove the plagiarism and re-upload the track to the release,'));
            }
            return true;
        } else {
            return false;
        }
    }
}
