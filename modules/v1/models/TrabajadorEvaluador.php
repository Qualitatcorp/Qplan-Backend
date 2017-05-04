<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "trabajador_evaluador".
 *
 * @property integer $id
 * @property string $tra_id
 * @property string $tipo
 * @property string $inicio
 * @property string $termino
 * @property string $creacion
 */
class TrabajadorEvaluador extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'trabajador_evaluador';
    }


    public function rules()
    {
        return [
            [['tra_id', 'tipo', 'inicio', 'termino'], 'required'],
            [['tra_id'], 'integer'],
            [['tipo'], 'string'],
            [['inicio', 'termino', 'creacion'], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tra_id' => 'Tra ID',
            'tipo' => 'Tipo',
            'inicio' => 'Inicio',
            'termino' => 'Termino',
            'creacion' => 'Creacion',
        ];
    }
}
