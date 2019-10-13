<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_jenis_pembayaran".
 *
 * @property int $id
 * @property string $jenis
 * @property string $created_date
 * @property string $created_by
 */
class MJenisPembayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_jenis_pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['jenis'], 'string', 'max' => 100],
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
            'jenis' => 'Jenis',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
