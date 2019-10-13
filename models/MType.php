<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_type".
 *
 * @property int $id
 * @property string $type
 * @property string $created_date
 * @property string $created_by
 */
class MType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['type'], 'string', 'max' => 100],
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
            'type' => 'Type',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
