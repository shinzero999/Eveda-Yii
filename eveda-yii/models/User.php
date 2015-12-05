<?php

namespace app\models;

use Yii;
use app\modules\admin\models\Event;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Url;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property integer $role
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $empty_pwd
 * @property integer $status
 * @property string $display_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Event[] $events
 * @property Follow[] $follows
 * @property Read[] $reads
 * @property Upgrade[] $upgrades
 */
class User extends ActiveRecord implements IdentityInterface
{
    //Attribute for counting user public events
    public $eventsCount;

    //Constant for status
    const STATUS_DELETED       = 0;
    const STATUS_NEW           = 1;
    const STATUS_ACTIVE        = 10;

    //Constant for user's role
    const ROLE_USER            = 0;
    const ROLE_PREMIUM_USER    = 3;
    const ROLE_STAFF           = 5;
    const ROLE_ADMIN           = 10;
    const ROLE_SUPER_ADMIN     = 100;

    //Array of user's role
    public static $roles = [
        self::ROLE_USER => 'User',
        self::ROLE_PREMIUM_USER => 'Premium user',
        self::ROLE_STAFF => 'Staff',
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_SUPER_ADMIN => 'Super Admin',
    ];

    public static $rolesForUser = [
        self::ROLE_USER => 'User',
        self::ROLE_PREMIUM_USER => 'Premium user',
    ];

    //Array for status
    public static $status = [
        self::STATUS_DELETED => 'Deleted',
        self::STATUS_NEW => 'New',
        self::STATUS_ACTIVE => 'Active',
    ];
    
    public static $colors = [
        self::STATUS_DELETED => 'danger',
        self::STATUS_NEW => 'warning',
        self::STATUS_ACTIVE => 'success',
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['status', 'in', 'range' => [self::STATUS_NEW, self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsernameOnly($username)
    {
        return static::findOne(['display_name' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }


    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollows()
    {
        return $this->hasMany(Follow::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReads()
    {
        return $this->hasMany(Read::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpgrades()
    {
        return $this->hasMany(Upgrade::className(), ['user_id' => 'id']);
    }

    public function generateActivationLink(){
        return Url::to(['/site/activate', 'code' => $this->getAuthKey()], true);
    }

    //Get user's role name
    public function getRoleName(){
        return self::$roles[$this->role];
    }

    //Get user's status name
    public function getStatusName(){
        return self::$status[$this->status];
    }

    //Get status color for view
    public function getStatusColor(){
        return self::$colors[$this->status];
    }

    //Chech user is premium or not
    public function isPremium(){
        return $this->role == self::ROLE_PREMIUM_USER;
    }
}
