<?php

namespace frontend\models;


use Yii;
use frontend\models\Biodata;

/**
 * This is the model class for table "pekerjaan".
 *
 * @property int $id
 * @property int $biodata_id
 * @property string $nama_perusahaan
 * @property string $posisi_terakhir
 * @property int $pendapatan_terakhir
 * @property int $tahun_masuk
 * @property int $tahun_keluar
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Biodata $biodata
 */
class Pekerjaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pekerjaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_perusahaan', 'posisi_terakhir', 'pendapatan_terakhir', 'tahun_masuk', 'tahun_keluar'], 'required'],
            [['pendapatan_terakhir', 'tahun_masuk', 'tahun_keluar'], 'default', 'value' => null],
            [['pendapatan_terakhir', 'tahun_masuk', 'tahun_keluar'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama_perusahaan', 'posisi_terakhir'], 'string', 'max' => 255],
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
            'nama_perusahaan' => 'Nama Perusahaan',
            'posisi_terakhir' => 'Posisi Terakhir',
            'pendapatan_terakhir' => 'Pendapatan Terakhir',
            'tahun_masuk' => 'Tahun Masuk',
            'tahun_keluar' => 'Tahun Keluar',
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
