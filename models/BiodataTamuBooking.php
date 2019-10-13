<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "biodata_tamu_booking".
 *
 * @property int $id
 * @property string $nama
 * @property string $identitas
 * @property string $nomor_identitas
 * @property string $nomor_kontak
 * @property string $alamat
 * @property string $created_date
 * @property string $created_by
 */
class BiodataTamuBooking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'biodata_tamu_booking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['identitas'], 'string'],
            [['created_date'], 'safe'],
            [['nama', 'alamat'], 'string', 'max' => 255],
            [['nomor_identitas', 'nomor_kontak'], 'string', 'max' => 100],
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
            'nama' => 'Nama',
            'identitas' => 'Identitas',
            'nomor_identitas' => 'Nomor Identitas',
            'nomor_kontak' => 'Nomor Kontak',
            'alamat' => 'Alamat',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
