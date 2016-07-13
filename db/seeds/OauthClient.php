<?php

use Phinx\Seed\AbstractSeed;

class OauthClient extends AbstractSeed
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
        $this->execute('TRUNCATE oauth2_clients');

        $data = [
            [
                'client_id'=>'cliente',
                'secret'=>'segredo'
            ]
        ];

        $table = $this->table('oauth2_clients');
        $table->insert($data)
            ->save();
    }
}
