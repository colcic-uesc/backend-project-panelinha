<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUserIdToTables extends AbstractMigration
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
    public function change(): void
    {
        // Adiciona user_id na tabela professors
        $table = $this->table('professors');
        $table->addColumn('user_id', 'integer', ['signed' => false, 'null' => true, 'after' => 'id'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION'])
            ->update();

        // Adiciona user_id na tabela students
        $table = $this->table('students');
        $table->addColumn('user_id', 'integer', ['signed' => false, 'null' => true, 'after' => 'id'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION'])
            ->update();
    }
}
