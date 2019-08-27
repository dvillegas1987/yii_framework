<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cre_rol".
 *
 * @property string $codigo
 * @property string $descripcion
 *
 * @property SegUsers[] $segUsers
 */
class Rol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSegUsers()
    {
        return $this->hasMany(SegUsers::className(), ['role' => 'codigo']);
    }
}
