<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProjectSkillsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('project_skills', ['id' => false, 'primary_key' => ['project_id', 'skill_id']]);
        $table->addColumn('project_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('skill_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('weight', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('project_id', 'projects', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('skill_id', 'skills', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }
}
