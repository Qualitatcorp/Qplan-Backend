<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "trabajador".
 *
 * @property string $id
 * @property integer $com_id
 * @property string $rut
 * @property string $nombre
 * @property string $paterno
 * @property string $materno
 * @property string $nacimiento
 * @property string $fono
 * @property string $mail
 * @property string $gerencia
 * @property integer $antiguedad
 * @property string $civil
 * @property integer $hijos
 * @property string $licencia
 * @property string $talla
 * @property string $direccion
 * @property string $contacto
 * @property string $afp
 * @property string $prevision
 * @property string $nivel
 * @property string $creacion
 * @property string $modificacion
 *
 * @property Ficha[] $fichas
 * @property OrdenTrabajo[] $ots
 * @property OrdenTrabajoTrabajador[] $ordenTrabajoTrabajadors
 * @property OrdenTrabajo[] $ots0
 * @property Comuna $com
 * @property TrabajadorExperiencia[] $trabajadorExperiencias
 */
class Trabajador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trabajador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['com_id', 'antiguedad', 'hijos'], 'integer'],
            [['rut'], 'required'],
            [['nacimiento', 'creacion', 'modificacion'], 'safe'],
            [['civil', 'licencia', 'talla', 'direccion', 'afp', 'prevision', 'nivel'], 'string'],
            [['rut'], 'string', 'max' => 12],
            [['nombre', 'paterno', 'materno'], 'string', 'max' => 64],
            [['fono'], 'string', 'max' => 36],
            [['mail', 'gerencia'], 'string', 'max' => 128],
            [['contacto'], 'string', 'max' => 256],
            [['rut'], 'unique'],
            [['com_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comuna::className(), 'targetAttribute' => ['com_id' => 'com_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'com_id' => 'Com ID',
            'rut' => 'Rut',
            'nombre' => 'Nombre',
            'paterno' => 'Paterno',
            'materno' => 'Materno',
            'nacimiento' => 'Nacimiento',
            'fono' => 'Fono',
            'mail' => 'Mail',
            'gerencia' => 'Gerencia',
            'antiguedad' => 'Antiguedad',
            'civil' => 'Civil',
            'hijos' => 'Hijos',
            'licencia' => 'Licencia',
            'talla' => 'Talla',
            'direccion' => 'Direccion',
            'contacto' => 'Contacto',
            'afp' => 'Afp',
            'prevision' => 'Prevision',
            'nivel' => 'Nivel',
            'creacion' => 'Creacion',
            'modificacion' => 'Modificacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFichas()
    {
        return $this->hasMany(Ficha::className(), ['tra_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOts()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['id' => 'ot_id'])->viaTable('ficha', ['tra_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenTrabajoTrabajadors()
    {
        return $this->hasMany(OrdenTrabajoTrabajador::className(), ['tra_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOts0()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['id' => 'ot_id'])->viaTable('orden_trabajo_trabajador', ['tra_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCom()
    {
        return $this->hasOne(Comuna::className(), ['com_id' => 'com_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajadorExperiencias()
    {
        return $this->hasMany(TrabajadorExperiencia::className(), ['tra_id' => 'id']);
    }
}
