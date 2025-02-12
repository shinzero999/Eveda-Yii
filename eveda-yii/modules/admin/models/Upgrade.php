<?php

namespace app\modules\admin\models;
use app\models\User;

use Yii;

/**
 * This is the model class for table "upgrade".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $phone_number
 * @property string $address
 * @property string $about
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Upgrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'upgrade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['phone_number', 'address', 'about'], 'string', 'max' => 255],
            [['phone_number'], 'validatePhoneNumber'],
        ];
    }

    public function validatePhoneNumber($attribute, $params)
    {
        if (!preg_match('/^[0-9]*$/', $this->$attribute)) {
             $this->addError($attribute, 'Phone number should only contain numbers');
        }
        if (!preg_match('/^.{10,11}$/', $this->$attribute) ) {
             $this->addError($attribute, 'Phone number must be between 10 to 11 characters.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'about' => 'About',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
