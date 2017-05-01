<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ficha".
 *
 * @property string $id
 * @property string $ot_id
 * @property string $tra_id
 * @property string $proceso
 * @property string $creacion
 *
 * @property OrdenTrabajo $ot
 * @property Trabajador $tra
 * @property FichaPractica[] $fichaPracticas
 * @property PerfilModulo[] $mods
 */
class Ficha extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ficha';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ot_id', 'tra_id'], 'required'],
            [['ot_id', 'tra_id'], 'integer'],
            [['proceso'], 'string'],
            [['creacion'], 'safe'],
            // [['ot_id', 'tra_id'], 'unique', 'targetAttribute' => ['ot_id', 'tra_id'], 'message' => 'The combination of Ot ID and Tra ID has already been taken.'],
            [['ot_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrdenTrabajo::className(), 'targetAttribute' => ['ot_id' => 'id']],
            [['tra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['tra_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ot_id' => 'Ot ID',
            'tra_id' => 'Tra ID',
            'proceso' => 'Proceso',
            'creacion' => 'Creacion',
        ];
    }

    public function extraFields()
    {
        return ['ot','trabajador','ficpracticas','modulos','ficteoricas'];
    }

    public function getOt()
    {
        return $this->hasOne(OrdenTrabajo::className(), ['id' => 'ot_id']);
    }

    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['id' => 'tra_id']);
    }

    public function getFicpracticas()
    {
        return $this->hasMany(FichaPractica::className(), ['fic_id' => 'id']);
    }    
    public function getFicteoricas()
    {
        return $this->hasMany(FichaTeorico::className(), ['fic_id' => 'id']);
    }

    public function getModulos()
    {
        return $this->hasMany(PerfilModulo::className(), ['id' => 'mod_id'])->viaTable('ficha_practica', ['fic_id' => 'id']);
    }
}
