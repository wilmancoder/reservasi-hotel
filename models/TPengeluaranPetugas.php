<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_pengeluaran_petugas".
 *
 * @property int $id
 * @property int $id_petugas
 * @property int $id_user
 * @property string $item
 * @property int $qty
 * @property string $harga_per_item
 * @property string $tgl_uangkeluar
 * @property string $total_harga_item
 */
class TPengeluaranPetugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_pengeluaran_petugas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_petugas', 'id_user', 'qty'], 'integer'],
            [['tgl_uangkeluar'], 'safe'],
            [['item'], 'string', 'max' => 255],
            [['harga_per_item', 'total_harga_item'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_petugas' => 'Id Petugas',
            'id_user' => 'Id User',
            'item' => 'Item',
            'qty' => 'Qty',
            'harga_per_item' => 'Harga Per Item',
            'tgl_uangkeluar' => 'Tgl Uangkeluar',
            'total_harga_item' => 'Total Harga Item',
        ];
    }
}
