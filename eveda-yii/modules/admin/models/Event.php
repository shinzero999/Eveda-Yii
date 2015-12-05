<?php

namespace app\modules\admin\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $location
 * @property string $start_date
 * @property string $end_date
 * @property string $url
 * @property string $notes
 * @property string $image
 * @property integer $visibility
 * @property integer $region_id
 * @property integer $genre_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Genre $genre
 * @property Region $region
 * @property User $user
 * @property EventPost[] $eventPosts
 * @property Follow[] $follows
 * @property Read[] $reads
 */
class Event extends \yii\db\ActiveRecord
{
    const VISIBILITY_PRIVATE   = 0;
    const VISIBILITY_PUBLIC    = 1;

    public static $status = [
        self::VISIBILITY_PRIVATE => 'Private',
        self::VISIBILITY_PUBLIC => 'Public',
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'region_id', 'genre_id'], 'required'],
            [['user_id', 'visibility', 'region_id', 'genre_id'], 'integer'],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'safe'],
            [['title', 'location', 'url', 'notes', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'location' => 'Location',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'url' => 'Url',
            'notes' => 'Notes',
            'image' => 'Image',
            'visibility' => 'Visibility',
            'region_id' => 'Region ID',
            'genre_id' => 'Genre ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventPosts()
    {
        return $this->hasMany(EventPost::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollows()
    {
        return $this->hasMany(Follow::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReads()
    {
        return $this->hasMany(Read::className(), ['event_id' => 'id']);
    }
}
