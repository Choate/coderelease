<?php
use yii\db\Migration;
use yii\db\Schema;

class m151028_082547_init extends Migration
{
    public function safeUp() {
        $this->createTable('%websites', [
                'id'      => Schema::TYPE_PK,
                'website' => Schema::TYPE_STRING . '(200) NOT NULL',
                'name'    => Schema::TYPE_STRING . '(45) NOT NULL',
                'status'  => 'TINYINT(1) NOT NULL',
            ]
        );
        $this->createTable('%tasks', [
                'id'          => Schema::TYPE_PK,
                'title'       => Schema::TYPE_STRING . '(100) NOT NULL',
                'hash'        => 'CHAR(32) NOT NULL',
                'applicant'   => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'apply_time'  => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'auditor'     => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'audit_time'  => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'websites_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'status'      => 'TINYINT(1) NOT NULL',
            ]
        );
        $this->createTable('%website_config', [
            'id'          => Schema::TYPE_PK,
            'setting'     => Schema::TYPE_TEXT,
            'websites_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
        ]
        );
        $this->createIndex('websites_id', '%tasks', ['websites_id']);
        $this->createIndex('tasks_hash', '%tasks', ['hash']);
        $this->createIndex('websites_id', '%website_config', ['websites_id']);

        return true;
    }

    public function safeDown() {
        $this->dropTable('IF EXISTS {{%website_config}}');
        $this->dropTable('IF EXISTS {{%websites}}');
        $this->dropTable('IF EXISTS {{%tasks}}');

        return true;
    }
}
