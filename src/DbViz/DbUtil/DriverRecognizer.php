<?php

namespace DbViz\DbUtil;

use DbViz\Constant\DbDrivers;
use DbViz\Entity\ConnectionCredentials;
use Exception;
use PDO;
use PDOException;


class DriverRecognizer
{
	public function __construct()
	{
	}

	public function getDriverName(ConnectionCredentials $connectionCredentials)
	{
		$dsn = $connectionCredentials->getDsn();
		switch(strtolower(preg_replace('/^([^:]*):.*/', '\1', $dsn))) {
			case 'odbc':
				return $this->getOdbcDriverName($connectionCredentials);

			case 'sqlite':
				return DbDrivers::SQLITE;

			default:
				throw new Exception("Could not recognize driver from dsn: $dsn");
		}
	}

	protected function getOdbcDriverName(ConnectionCredentials $connectionCredentials)
	{
		$driver = $this->getOdbcDriverNameFromDsn($connectionCredentials);
		if(null !== $driver) {
			return $driver;
		}

		$driver = $this->getOdbcDriverNameFromConnection($connectionCredentials);
		if(null !== $driver) {
			return $driver;
		}

		throw new Exception('Could not retrieve odbc driver');
	}

	protected function getOdbcDriverNameFromDsn(ConnectionCredentials $connectionCredentials)
	{
		$dsn = substr($connectionCredentials->getDsn(), 0, 5); // dsn should start with "odbc:"
		$resultCount = preg_match('/driver\s*=([^;]*)/i', $dsn, $driverMatch);
		if(0 === $resultCount) {
			return null;
		}
		switch(strtolower(trim($driverMatch[1]))) {
			case 'sqlite3':
				return DbDrivers::SQLITE;

			default:
				return null;
		}
	}
	
	protected function getOdbcDriverNameFromConnection(ConnectionCredentials $connectionCredentials)
	{
		try {
			$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->query('select * from wrongnonexistingtablehopingforanexception');
			return null;
		} catch(PDOException $e) {
			$errorMessage = strtolower($e->getMessage());
		}
		switch(true) {
			case strpos($errorMessage, '[microsoft][odbc sql server driver]') !== false:
				return DbDrivers::MSSQL;

			case strpos($errorMessage, '[odbc interbase driver][interbase]') !== false:
				return DbDrivers::INTERBASE;

			default:
				return null;
		}
	}
}
 
