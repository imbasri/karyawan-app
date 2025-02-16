<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Pekerjaan;
use frontend\models\Pelatihan;
use frontend\models\Pendidikan;
use frontend\models\User;

/**
 * This is the model class for table "biodata".
 *
 * @property int $id
 * @property int $user_id
 * @property string $posisi_dilamar
 * @property string $nama_lengkap
 * @property string $tanggal_lahir
 * @property string $tempat_lahir
 * @property string $jenis_kelamin
 * @property string $agama
 * @property string $golongan_darah
 * @property string $status_pernikahan
 * @property string $alamat_ktp
 * @property string $alamat_tinggal
 * @property string $email
 * @property string $no_telp
 * @property string $orang_terdekat
 * @property string $no_telp_orang_terdekat
 * @property string $skill
 * @property string $bersedia_ditempatkan
 * @property int $penghasilan_diinginkan
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Pekerjaan[] $pekerjaans
 * @property Pelatihan[] $pelatihans
 * @property Pendidikan[] $pendidikans
 * @property User $user
 */
class Biodata extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'biodata';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'posisi_dilamar', 'nama_lengkap', 'tanggal_lahir', 'tempat_lahir', 'agama', 'alamat_ktp', 'alamat_tinggal', 'email', 'no_telp', 'orang_terdekat', 'no_telp_orang_terdekat', 'skill', 'penghasilan_diinginkan'], 'required'],
            [['user_id', 'penghasilan_diinginkan'], 'default', 'value' => null],
            [['user_id', 'penghasilan_diinginkan'], 'integer'],
            [['alamat_ktp', 'alamat_tinggal', 'skill'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['posisi_dilamar', 'nama_lengkap', 'jenis_kelamin', 'agama', 'golongan_darah', 'status_pernikahan', 'email', 'no_telp', 'orang_terdekat', 'no_telp_orang_terdekat', 'bersedia_ditempatkan'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'posisi_dilamar' => 'Posisi Dilamar',
            'nama_lengkap' => 'Nama Lengkap',
            'tanggal_lahir' => 'Tanggal Lahir',
            'tempat_lahir' => 'Tempat Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'agama' => 'Agama',
            'golongan_darah' => 'Golongan Darah',
            'status_pernikahan' => 'Status Pernikahan',
            'alamat_ktp' => 'Alamat Ktp',
            'alamat_tinggal' => 'Alamat Tinggal',
            'email' => 'Email',
            'no_telp' => 'No Telp',
            'orang_terdekat' => 'Orang Terdekat',
            'no_telp_orang_terdekat' => 'No Telp Orang Terdekat',
            'skill' => 'Skill',
            'bersedia_ditempatkan' => 'Bersedia Ditempatkan',
            'penghasilan_diinginkan' => 'Penghasilan Diinginkan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Pekerjaans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPekerjaans()
    {
        return $this->hasMany(Pekerjaan::class, ['biodata_id' => 'id']);
    }

    /**
     * Gets query for [[Pelatihans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPelatihans()
    {
        return $this->hasMany(Pelatihan::class, ['biodata_id' => 'id']);
    }

    /**
     * Gets query for [[Pendidikans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPendidikans()
    {
        return $this->hasMany(Pendidikan::class, ['biodata_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
