<?php

namespace WebDevBr\Storage;

use WebDevBr\OAuth2\Storage\StorageInterface;

class Client extends Storage implements StorageInterface
{
	public function get($id)
	{
		$qb = $this->getDb();
		$result = $qb->select('*')
			->from('oauth2_clients')
			->where('client_id=?')
            ->setParameter(0, $id)
			->execute()
			->fetch();

		if (!$result) {
			return false;
		}

		return (object)$result;
	}

    public function insert(\stdClass $data)
    {
    	$qb = $this->getDb();
    	$qb->insert('oauth2_clients')
    		->value([
    			'client_id'=>'?',
    			'secret'=>'?'
    		])
    		->setParameters([
    			0=>$data->client_id,
    			1=>$data->secret
    		])
    		->execute();
    }

    public function remove($id)
    {
    	$qb = $this->getDb();
    	$qb->delete('oauth2_clients')
    		->where('id='.$id)
    		->execute();
    }

}