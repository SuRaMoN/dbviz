<?php

namespace DbViz\Entity;


class ConnectionCredentials
{
	protected $dsn;
	protected $username;
	protected $password;

	public function __construct($dsn, $username = null, $password = null)
	{
		$this->dsn = $dsn;
		$this->username = $username;
		$this->password = $password;
	}
 
 	public function getDsn()
 	{
 		return $this->dsn;
 	}

 	public function getUsername()
 	{
 		return $this->username;
 	}
 
 	public function getPassword()
 	{
 		return $this->password;
 	}
}
 
