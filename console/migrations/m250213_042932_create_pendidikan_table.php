<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pendidikan}}`.
 */
class m250213_042932_create_pendidikan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pendidikan}}', [
            'id' => $this->primaryKey(),
            'biodata_id' => $this->integer()->null(),
            'jenjang_pendidikan' => $this->string()->null(),
            'nama_institusi' => $this->string()->null(),
            'jurusan' => $this->string()->null(),
            'tahun_lulus' => $this->integer()->null(),
            'ipk' => $this->decimal(3, 2)->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_biodata_id', '{{%pendidikan}}', 'biodata_id', '{{%biodata}}', 'id', 'CASCADE', 'CASCADE');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_biodata_id', '{{%pendidikan}}');
        $this->dropTable('{{%pendidikan}}');
    }
}
