<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_petugas".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_shift
 * @property string $sign_in
 * @property string $sign_out
 */
class TPetugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_petugas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_shift'], 'integer'],
            [['sign_in', 'sign_out'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_shift' => 'Id Shift',
            'sign_in' => 'Sign In',
            'sign_out' => 'Sign Out',
        ];
    }
}
