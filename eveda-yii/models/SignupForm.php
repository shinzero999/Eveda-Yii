<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{

    public $email;
    public $password;
    public $display_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required', 'on' => 'signup'], 
            ['password', 'string', 'min' => 3, 'on' => 'signup'],

            ['display_name', 'required', 'on' => 'signup'],
            ['display_name', 'string', 'on' => 'signup'],
            ['display_name', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This name has already been taken.'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {

            $user = new User();
            $user->status = User::STATUS_ACTIVE;
            $user->email = $this->email;
            $user->display_name = $this->display_name;
            
            if ($this->scenario != 'signup' && empty($this->password)) {    
                $user->setPassword(Yii::$app->security->generateRandomString(8));
                $user->empty_pwd = 1; // true
            } else {
                $user->setPassword($this->password);
            }

            $user->generateAuthKey();

            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
