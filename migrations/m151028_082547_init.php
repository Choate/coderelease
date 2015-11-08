<?php
use choate\coderelease\models\entities\Deploy;
use choate\coderelease\models\entities\DeployHasTasks;
use choate\coderelease\models\entities\Tasks;
use choate\coderelease\models\entities\Websites;
use yii\db\Migration;
use yii\db\Schema;

class m151028_082547_init extends Migration
{
    public function up() {
        try {
            self::safeUp();
        } catch (\Exception $e) {
            $this->down();
            throw $e;
        }
    }

    public function safeUp() {
        $this->createTable(Websites::tableName(), [
                'id'             => Schema::TYPE_PK,
                'website'        => Schema::TYPE_STRING . '(200) NOT NULL',
                'name'           => Schema::TYPE_STRING . '(45) NOT NULL',
                'deploy_script'  => Schema::TYPE_STRING . '(255) NOT NULL',
                'deploy_project' => Schema::TYPE_STRING . '(45) NOT NULL',
            ]
        );
        $this->createTable(Tasks::tableName(), [
                'id'          => Schema::TYPE_PK,
                'title'       => Schema::TYPE_STRING . '(100) NOT NULL',
                'hash'        => 'CHAR(32) NOT NULL',
                'applicant'   => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0 COMMENT "申请人"',
                'apply_time'  => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0 COMMENT "申请时间"',
                'auditor'     => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0 COMMENT "审核人"',
                'audit_time'  => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0 COMMENT "审核时间"',
                'websites_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
                'status'      => 'TINYINT(1) NOT NULL COMMENT "状态：0 审核、1 审核通过、2 部署成功"',
            ]
        );
        $this->createTable(Deploy::tableName(), [
                'id'             => Schema::TYPE_PK,
                'deployer'       => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0 COMMENT "部署人"',
                'deploy_time'    => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0 COMMENT "部署时间"',
                'deploy_version' => Schema::TYPE_STRING . '(45) NOT NULL DEFAULT "" COMMENT "部署版本"',
                'status'         => 'tinyint(1) NOT NULL DEFAULT 0 COMMENT "状态：0 部署成功、1 回滚成功"',
                'message'        => Schema::TYPE_STRING . '(2000) NOT NULL DEFAULT "" COMMENT "日志"',
                'websites_id'    => Schema::TYPE_INTEGER . '(11) NOT NULL',
            ]
        );
        $this->createIndex('websites_id', Tasks::tableName(), ['websites_id']);
        $this->createIndex('tasks_hash', Tasks::tableName(), ['hash']);
        $this->createIndex('websites_id', Deploy::tableName(), ['websites_id']);

        return true;
    }

    public function safeDown() {
        $this->dropTable('IF EXISTS ' . Websites::tableName());
        $this->dropTable('IF EXISTS ' . Tasks::tableName());
        $this->dropTable('IF EXISTS ' . Deploy::tableName());

        return true;
    }
}
