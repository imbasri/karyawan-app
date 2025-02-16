<?php

namespace frontend\models;

use Yii;
use frontend\models\Biodata;
/**
 * This is the model class for table "pelatihan".
 *
 * @property int $id
 * @property int $biodata_id
 * @property string $nama_pelatihan
 * @property bool $sertifikat
 * @property int $tahun
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Biodata $biodata
 */
class Pelatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelatihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_pelatihan', 'tahun'], 'required'],
            [['tahun'], 'default', 'value' => null],
            [['tahun'], 'integer'],
            [['sertifikat'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama_pelatihan'], 'string', 'max' => 255],
            [['biodata_id'], 'exist', 'skipOnError' => true, 'targetClass' => Biodata::class, 'targetAttribute' => ['biodata_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            // 'biodata_id' => 'Biodata ID',
            'nama_pelatihan' => 'Nama Pelatihan',
            'sertifikat' => 'Sertifikat',
            'tahun' => 'Tahun',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Biodata]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBiodata()
    {
        return $this->hasOne(Biodata::class, ['id' => 'biodata_id']);
    }
}
