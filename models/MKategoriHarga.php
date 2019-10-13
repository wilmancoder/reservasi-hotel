<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_kategori_harga".
 *
 * @property int $id
 * @property string $kategori_harga
 * @property string $created_date
 * @property string $created_by
 */
class MKategoriHarga extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_kategori_harga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['kategori_harga'], 'string', 'max' => 100],
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
            'kategori_harga' => 'Kategori Harga',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
