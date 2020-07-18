<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_bed".
 *
 * @property int $id
 * @property int $id_biodata_tamu
 * @property int $id_petugas
 * @property int $id_mapping_harga
 * @property int $qty_bed
 * @property string $harga_bed
 */
class TBed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_bed';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_biodata_tamu', 'id_petugas', 'id_mapping_harga', 'qty_bed'], 'integer'],
            [['harga_bed'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_biodata_tamu' => 'Id Biodata Tamu',
            'id_petugas' => 'Id Petugas',
            'id_mapping_harga' => 'Id Mapping Harga',
            'qty_bed' => 'Qty Bed',
            'harga_bed' => 'Harga Bed',
        ];
    }
}
