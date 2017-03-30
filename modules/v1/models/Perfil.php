<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "perfil".
 *
 * @property string $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $documento
 *
 * @property ClasificacionPerfil[] $clasificacionPerfils
 * @property Clasificacion[] $clas
 * @property EmpresaClasificacion[] $empresaClasificacions
 * @property OrdenTrabajo[] $ordenTrabajos
 * @property PerfilEspecialidad[] $perfilEspecialidads
 * @property Especialidad[] $esps
 * @property PerfilModulo[] $perfilModulos
 */
class Perfil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['descripcion', 'documento'], 'string'],
            [['nombre'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'documento' => 'Documento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasificacionPerfils()
    {
        return $this->hasMany(ClasificacionPerfil::className(), ['per_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClas()
    {
        return $this->hasMany(Clasificacion::className(), ['id' => 'cla_id'])->viaTable('clasificacion_perfil', ['per_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresaClasificacions()
    {
        return $this->hasMany(EmpresaClasificacion::className(), ['per_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdenTrabajos()
    {
        return $this->hasMany(OrdenTrabajo::className(), ['per_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilEspecialidads()
    {
        return $this->hasMany(PerfilEspecialidad::className(), ['per_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEsps()
    {
        return $this->hasMany(Especialidad::className(), ['id' => 'esp_id'])->viaTable('perfil_especialidad', ['per_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerfilModulos()
    {
        return $this->hasMany(PerfilModulo::className(), ['per_id' => 'id']);
    }
}
