<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "summary_ttamu".
 *
 * @property int $id
 * @property int $id_transaksi_tamu
 * @property int $id_petugas
 * @property string $dp
 * @property string $sisa
 * @property string $total_harga
 * @property string $total_bayar
 */
class SummaryTtamu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'summary_ttamu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transaksi_tamu', 'id_petugas'], 'integer'],
            [['dp', 'sisa', 'total_harga', 'total_bayar'], 'string', 'max' => 100],
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
            'dp' => 'Dp',
            'sisa' => 'Sisa',
            'total_harga' => 'Total Harga',
            'total_bayar' => 'Total Bayar',
        ];
    }
}
