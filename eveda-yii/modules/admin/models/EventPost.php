<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "event_post".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $status
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Event $event
 */
class EventPost extends \yii\db\ActiveRecord
{
    const STATUS_DELETED       = 0;
    const STATUS_NEW           = 1;
    const STATUS_POST          = 10;

    public static $status = [
        self::STATUS_DELETED => 'Deleted',
        self::STATUS_NEW => 'New',
        self::STATUS_POST => 'Post',
    ];

    public static $colors = [
        self::STATUS_DELETED => 'danger',
        self::STATUS_NEW => 'warning',
        self::STATUS_POST => 'success',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['message'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'status' => 'Status',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }

    public function getStatusName(){
        return self::$status[$this->status];
    }

    public function getStatusColor(){
        return self::$colors[$this->status];
    }
}
