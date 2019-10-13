<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_metode_pembayaran".
 *
 * @property int $id
 * @property string $metode
 * @property string $created_date
 * @property string $created_by
 */
class MMetodePembayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_metode_pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['metode'], 'string', 'max' => 100],
            [['created_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'metode' => 'Metode',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
