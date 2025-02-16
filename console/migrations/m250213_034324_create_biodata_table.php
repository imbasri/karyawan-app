<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%biodata}}`.
 */
class m250213_034324_create_biodata_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%biodata}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'posisi_dilamar' => $this->string()->null(),
            'nama_lengkap' => $this->string()->null(),
            'tanggal_lahir' => $this->date()->null(),
            'tempat_lahir' => $this->string()->null(),
            'jenis_kelamin' => $this->string()->null()->check("jenis_kelamin IN ('Laki-laki', 'Perempuan')")->defaultValue('Laki-laki'),
            'agama' => $this->string()->null(),
            'golongan_darah' => $this->string()->null()->check("golongan_darah IN ('A', 'B', 'AB', 'O')")->defaultValue('A'),
            'status_pernikahan' => $this->string()->null()->check("status_pernikahan IN ('Menikah', 'Belum Menikah')")->defaultValue('Belum Menikah'),
            'alamat_ktp' => $this->text()->null(),
            'alamat_tinggal' => $this->text()->null(),
            'email' => $this->string()->null(),
            'no_telp' => $this->string()->null(),
            'orang_terdekat' => $this->string()->null(),
            'no_telp_orang_terdekat' => $this->string()->null(),
            'skill' => $this->text()->null(),
            'bersedia_ditempatkan' => $this->string()->null()->check("bersedia_ditempatkan IN ('Ya', 'Tidak')")->defaultValue('Ya'),
            'penghasilan_diinginkan' => $this->integer()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_user_id', '{{%biodata}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_id', '{{%biodata}}');
        $this->dropTable('{{%biodata}}');
    }
}
