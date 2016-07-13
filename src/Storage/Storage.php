<?php

namespace WebDevBr\Storage;

class Storage
{
	private $conn;

	public function setDb($conn)
	{
		$this->conn = $conn;
		return $this;
	}
	
	public function getDb()
	{
		return $this->conn->createQueryBuilder();
	}
}