<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_mapping_kamar".
 *
 * @property int $id
 * @property int $nomor_kamar
 * @property int $id_mapping_harga
 * @property int $status
 * @property string $created_date
 * @property string $created_by
 */
class MMappingKamar extends \yii\db\ActiveRecord
{
    public $type,$kategori_harga,$harga;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_mapping_kamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor_kamar', 'id_mapping_harga'], 'integer'],
            [['created_date'], 'safe'],
            [['created_by', 'status','type','kategori_harga','harga'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomor_kamar' => 'Nomor Kamar',
            'id_mapping_harga' => 'Id Mapping Harga',
            'status' => 'Status',
            'type' => 'Type',
            'kategori_harga' => 'Kategori Harga',
            'harga' => 'Harga',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
