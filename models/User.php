<?php

namespace app\models;

// use app\models\MShift;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $role;
    public $nama;
    public $email;
    public $nm_role;
    public $nm_shift;
    public $id_shift;
    public $start_date;
    public $end_date;
    public $range_date;
    public $id_petugas;
    public $id_user;
    public $sign_in;


    // private static $users = [
    //     '100' => [
    //         'id' => '100',
    //         'username' => 'admin',
    //         'password' => 'admin',
    //         'authKey' => 'test100key',
    //         'accessToken' => '100-token',
    //     ],
    //     '101' => [
    //         'id' => '101',
    //         'username' => 'demo',
    //         'password' => 'demo',
    //         'authKey' => 'test101key',
    //         'accessToken' => '101-token',
    //     ],
    // ];


    public static function tableName()
    {
        return 'users';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;


        $user = Users::find()->where(['username' => $id])->asArray()->one();
        $roles = MRoles::find()->where(['id' =>$user['role']])->asArray()->one();
        $shift = MShift::find()->where(['id'=>$user['id_shift']])->asArray()->one();
        $petugas = TPetugas::find()->where(['id_user' => $user['id']])->orderBy(['id' => SORT_DESC])->asArray()->one();
        $identity = new User();
        $identity->id           = $id;
        $identity->id_user      = $user['id'];
        $identity->username     = $id;
        $identity->id_shift     = $shift['id'];
        $identity->nm_shift     = $shift['nm_shift'];
        $identity->id_petugas   = $petugas['id'];
        $identity->sign_in   = $petugas['sign_in'];


        // $identity->start_date   = \app\components\Logic::ambilJamshift();
        // $identity->end_date     = $shift['end_date'];
        $identity->range_date   = $shift['range_date'];


        $identity->nama         = $user['nama'];
        $identity->email        = $user['email'];
        $identity->role         = $roles['id'];

        return $identity;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }
        //
        // return null;
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        // foreach (self::$users as $user) {
        //     if (strcasecmp($user['username'], $username) === 0) {
        //         return new static($user);
        //     }
        // }
        //
        // return null;
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
     public function validatePassword($password)
     {
         // return $this->password === $password;
         return $this->password === sha1($password);
     }


     public function setPassword($password)
     {
         $this->password = sha1($password);
     }

     /**
      * Generates "remember me" authentication key
      */
     public function generateAuthKey()
     {
         $this->authKey = Yii::$app->security->generateRandomString();
     }
}
