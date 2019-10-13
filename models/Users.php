<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $nama
 * @property string $password
 * @property string $email
 * @property int $role
 * @property int $id_shift
 * @property string $created_at
 * @property string $updated_at
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'nama', 'password'], 'required'],
            [['role', 'id_shift'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 20],
            [['nama', 'password', 'email'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'nama' => 'Nama',
            'password' => 'Password',
            'email' => 'Email',
            'role' => 'Role',
            'id_shift' => 'Id Shift',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
