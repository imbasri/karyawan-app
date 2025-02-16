<?php

namespace frontend\models;

use Yii;
use frontend\models\Biodata;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pendidikan".
 *
 * @property int $id
 * @property int $biodata_id
 * @property string $jenjang_pendidikan
 * @property string $nama_institusi
 * @property string $jurusan
 * @property int $tahun_lulus
 * @property float $ipk
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Biodata $biodata
 */
class Pendidikan extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendidikan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenjang_pendidikan', 'nama_institusi', 'jurusan', 'tahun_lulus', 'ipk'], 'required'],
            [['tahun_lulus'], 'default', 'value' => null],
            [['tahun_lulus'], 'integer'],
            [['ipk'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['jenjang_pendidikan', 'nama_institusi', 'jurusan'], 'string', 'max' => 255],
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
            'jenjang_pendidikan' => 'Jenjang Pendidikan',
            'nama_institusi' => 'Nama Institusi',
            'jurusan' => 'Jurusan',
            'tahun_lulus' => 'Tahun Lulus',
            'ipk' => 'Ipk',
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
