<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_shift".
 *
 * @property int $id
 * @property string $nm_shift
 * @property string $start_date
 * @property string $end_date
 * @property string $range_date
 * @property string $created_date
 * @property string $created_by
 */
class MShift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['nm_shift', 'start_date', 'end_date', 'range_date', 'created_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nm_shift' => 'Nm Shift',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'range_date' => 'Range Date',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
        ];
    }
}
