<?php

namespace WebDevBr\Storage;

use WebDevBr\OAuth2\Storage\StorageInterface;

class AccessToken extends Storage implements StorageInterface
{
    protected $type=0;

	public function get($id)
	{
        $qb = $this->getDb();
		$token = $qb->select('*')
            ->from('oauth2_token')
            ->where('token=?')
            ->andWhere('auth_token='.$this->type)
            ->setParameter(0, $id)
            ->execute()
            ->fetch();

        if (isset($token['expiration_date'])) {
            $date = new \DateTime($token['expiration_date']);
            $date_now = new \DateTime;

            if ($date >= $date_now) {
                return $token;
            }
        }

        return false;
	}

    public function insert(\stdClass $data)
    {
    	$expiration_date = new \DateTime;
        $expiration_date->add(new \DateInterval('PT1H'));

        $qb = $this->getDb();
        $qb->insert('oauth2_token')
            ->values([
                'token'=>'?',
                'expiration_date'=>'?',
                'auth_token'=>'?'
            ])
            ->setParameters([
                0=>$data->token,
                1=>$expiration_date->format('Y-m-d H:i:s'),
                2=>$this->type,
            ]);
        return $qb->execute() == 1;
    }

    public function remove($id)
    {
    	$qb = $this->getDb();
        $qb->delete('oauth2_token')
            ->where('token=?')
            ->setParameter(0, $id);

        return $qb->execute() == 1;
    }

}