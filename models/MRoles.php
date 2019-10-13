<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_roles".
 *
 * @property int $id
 * @property string $nm_role
 * @property string $created_at
 * @property string $created_by
 */
class MRoles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['nm_role'], 'string', 'max' => 100],
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
            'nm_role' => 'Nm Role',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
