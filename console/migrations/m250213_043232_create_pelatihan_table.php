<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pelatihan}}`.
 */
class m250213_043232_create_pelatihan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pelatihan}}', [
            'id' => $this->primaryKey(),
            'biodata_id' => $this->integer()->notNull(),
            'nama_pelatihan' => $this->string()->null(),
            'sertifikat' => $this->boolean()->defaultValue(false)->null(),
            'tahun' => $this->integer()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_biodata_id', '{{%pelatihan}}', 'biodata_id', '{{%biodata}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_biodata_id', '{{%pelatihan}}');
        $this->dropTable('{{%pelatihan}}');
    }
}
