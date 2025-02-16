<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pekerjaan}}`.
 */
class m250213_043420_create_pekerjaan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pekerjaan}}', [
            'id' => $this->primaryKey(),
            'biodata_id' => $this->integer()->notNull(),
            'nama_perusahaan' => $this->string()->null(),
            'posisi_terakhir' => $this->string()->null(),
            'pendapatan_terakhir' => $this->integer()->null(),
            'tahun_masuk' => $this->integer()->null(),
            'tahun_keluar' => $this->integer()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),

        ]);
        $this->addForeignKey('fk_biodata_id', '{{%pekerjaan}}', 'biodata_id', '{{%biodata}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_biodata_id', '{{%pekerjaan}}');
        $this->dropTable('{{%pekerjaan}}');
    }
}
