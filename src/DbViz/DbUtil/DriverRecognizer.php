<?php

namespace DbViz\DbUtil;

use DbViz\Constant\DbDriver;
use DbViz\Entity\ConnectionCredentials;
use DbViz\Exception\UnknownDriverException;
use PDO;
use PDOException;


class DriverRecognizer
{
	public function __construct()
	{
	}

	public function getDriver(ConnectionCredentials $connectionCredentials)
	{
		$dsn = $connectionCredentials->getDsn();
		switch(strtolower(preg_replace('/^([^:]*):.*/', '\1', $dsn))) {
			case 'mysql':
				return DbDriver::MYSQL();

			case 'odbc':
				return $this->getOdbcDriver($connectionCredentials);

			case 'sqlite':
				return DbDriver::SQLITE();

			default:
				throw new UnknownDriverException("Could not recognize driver from dsn: $dsn");
		}
	}

	protected function getOdbcDriver(ConnectionCredentials $connectionCredentials)
	{
		$driver = $this->getOdbcDriverFromDsn($connectionCredentials);
		if(null !== $driver) {
			return $driver;
		}

		$driver = $this->getOdbcDriverFromConnection($connectionCredentials);
		if(null !== $driver) {
			return $driver;
		}

		throw new UnknownDriverException('Could not retrieve odbc driver');
	}

	protected function getOdbcDriverFromDsn(ConnectionCredentials $connectionCredentials)
	{
		$dsn = substr($connectionCredentials->getDsn(), 5); // dsn should start with "odbc:"
		$resultCount = preg_match('/(?:driver|dsn)\s*=([^;]*)/i', $dsn, $driverMatch);
		if(0 === $resultCount) {
			return null;
		}
		switch(strtolower(trim($driverMatch[1]))) {
			case 'sqlite3 datasource':
			case 'sqlite3':
				return DbDriver::SQLITE();

			default:
				return null;
		}
	}
	
	protected function getOdbcDriverFromConnection(ConnectionCredentials $connectionCredentials)
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
				return DbDriver::MSSQL();

			case strpos($errorMessage, '[odbc sqlbase driver][sqlbase]') !== false:
				return DbDriver::SQLBASE();

			case strpos($errorMessage, '[odbc interbase driver][interbase]') !== false:
				return DbDriver::INTERBASE();

			default:
				return null;
		}
	}
}
 
