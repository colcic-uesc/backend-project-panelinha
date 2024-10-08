<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProjectsTable extends AbstractMigration
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
        $table = $this->table('projects', ['id' => 'id']);
        $table->addColumn('title', 'string', ['limit' => 100])
            ->addColumn('description', 'text')
            ->addColumn('type', 'string', ['limit' => 50])
            ->addColumn('start_date', 'date')
            ->addColumn('end_date', 'date', ['null' => true])
            ->addColumn('professor_id', 'integer', ['signed' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('professor_id', 'professors', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }
}
