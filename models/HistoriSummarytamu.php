<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "histori_summarytamu".
 *
 * @property int $id
 * @property int $id_transaksi_tamu
 * @property int $id_petugas
 * @property string $pembayaran
 * @property string $status_pembayaran
 * @property string $tgl_uangmasuk
 * @property string $jml_uangmasuk
 */
class HistoriSummarytamu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'histori_summarytamu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transaksi_tamu', 'id_petugas'], 'integer'],
            [['tgl_uangmasuk'], 'safe'],
            [['pembayaran', 'status_pembayaran', 'jml_uangmasuk'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_transaksi_tamu' => 'Id Transaksi Tamu',
            'id_petugas' => 'Id Petugas',
            'pembayaran' => 'Pembayaran',
            'status_pembayaran' => 'Status Pembayaran',
            'tgl_uangmasuk' => 'Tgl Uangmasuk',
            'jml_uangmasuk' => 'Jml Uangmasuk',
        ];
    }
}
