<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_tamu".
 *
 * @property int $id
 * @property int $id_biodata_tamu
 * @property int $id_mapping_kamar
 * @property int $id_mapping_pembayaran
 * @property string $checkin
 * @property string $checkout
 * @property string $durasi
 * @property string $harga
 * @property string $no_kartu_debit
 * @property int $status
 * @property string $created_date_cekin
 * @property string $created_by_cekin
 * @property string $created_date_cekout
 * @property string $created_by_cekout
 */
class TTamu extends \yii\db\ActiveRecord
{
    public $namatamu, $identitas,$alamat,$list_kamar,$nomor_identitas, $nomor_kontak, $hargaperkamar, $subtotalkamar,$no_kartu_debit;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_tamu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_biodata_tamu', 'id_mapping_kamar', 'id_mapping_pembayaran', 'status'], 'integer'],
            [['checkin', 'checkout', 'created_date_cekin', 'created_date_cekout'], 'safe'],
            [['durasi', 'harga', 'no_kartu_debit'], 'string', 'max' => 100],
            [['created_by_cekin', 'created_by_cekout'], 'string', 'max' => 50],
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
            'id_mapping_kamar' => 'Id Mapping Kamar',
            'id_mapping_pembayaran' => 'Id Mapping Pembayaran',
            'checkin' => 'Checkin',
            'checkout' => 'Checkout',
            'durasi' => 'Durasi',
            'harga' => 'Harga',
            'no_kartu_debit' => 'No Kartu Debit',
            'status' => 'Status',
            'created_date_cekin' => 'Created Date Cekin',
            'created_by_cekin' => 'Created By Cekin',
            'created_date_cekout' => 'Created Date Cekout',
            'created_by_cekout' => 'Created By Cekout',
            'hargaperkamar' => 'Harga Kamar',
            'subtotalkamar' => 'SubTotal'
        ];
    }
}
