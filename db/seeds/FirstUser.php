<?php

use Phinx\Seed\AbstractSeed;

class FirstUser extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $this->execute('TRUNCATE users');

        $data = [
            [
                'name' => 'Rodrigo Angelo',
                'email' => 'rodrigo@teste.com.br',
                'password' => '123456',
            ]
        ];

        $tasks = $this->table('users');
        $tasks->insert($data)
            ->save();
    }
}
