<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InsertAdminUser extends AbstractMigration
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
    public function up()
    {
        $this->table('users')->insert([
            'username' => 'admin',
            'password' => '$2y$10$MgZZ2sD3nQSWkJMBPuScbOXSE4NWC1NnRpUF3gSDd9XlUKrW8reBu',
            'rules' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ])->save();
    }

    public function down()
    {
        $this->execute("DELETE FROM users WHERE username = 'admin'");
    }
}
