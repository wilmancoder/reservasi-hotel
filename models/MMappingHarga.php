<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_mapping_harga".
 *
 * @property int $id
 * @property int $id_type
 * @property int $id_kategori_harga
 * @property string $harga
 * @property string $created_date
 * @property string $created_by
 */
class MMappingHarga extends \yii\db\ActiveRecord
{
    public $type,$kategori_harga;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_mapping_harga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_type', 'id_kategori_harga'], 'integer'],
            [['created_date'], 'safe'],
            [['harga'], 'string', 'max' => 100],
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
            'id_type' => 'Type',
            'id_kategori_harga' => 'Kategori Harga',
            'harga' => 'Harga',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
