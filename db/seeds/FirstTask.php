<?php

use Phinx\Seed\AbstractSeed;

class FirstTask extends AbstractSeed
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
        $this->execute('TRUNCATE tasks');

        $data = [
            [
                'title' => 'Nao fazer nada',
                'description' => 'Smart-soul-delay tattoo shanty town fetishism futurity otaku bicycle industrial grade lights. Kowloon cartel marketing Shibuya shanty town faded papier-mache weathered RAF. Bomb lights disposable knife youtube sprawl shanty town construct voodoo god vinyl bridge shrine j-pop market nano. DIY franchise crypto-sprawl sensory saturation point uplink garage numinous. Tanto knife marketing motion chrome advert boy paranoid-ware dissident drone skyscraper ablative tube smart-lights Chiba. ',
                'datetime' => '2015-12-25 08:30:00',
                'checked' => true
            ]
        ];

        $tasks = $this->table('tasks');
        $tasks->insert($data)->save();
    }
}
