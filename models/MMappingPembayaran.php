<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_mapping_pembayaran".
 *
 * @property int $id
 * @property int $id_metode_pembayaran
 * @property int $id_jenis_pembayaran
 * @property string $created_date
 * @property string $created_by
 */
class MMappingPembayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_mapping_pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_metode_pembayaran', 'id_jenis_pembayaran'], 'integer'],
            [['created_date'], 'safe'],
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
            'id_metode_pembayaran' => 'Id Metode Pembayaran',
            'id_jenis_pembayaran' => 'Id Jenis Pembayaran',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
