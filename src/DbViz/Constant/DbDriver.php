<?php

namespace DbViz\Constant;


class DbDriver
{
	protected static $instances = array();

	protected $driver;

	protected function __construct($driver)
	{
		$this->driver = $driver;
	}

	protected static function getInstance($driver)
	{
		if(! array_key_exists($driver, self::$instances)) {
			self::$instances[$driver] = new self($driver);
		}
		return self::$instances[$driver];
	}

	public function __toString()
	{
		return $this->driver;
	}

	public static function SQLBASE()
	{
		return self::getInstance(__FUNCTION__);
	}

	public static function INTERBASE()
	{
		return self::getInstance(__FUNCTION__);
	}

	public static function MSSQL()
	{
		return self::getInstance(__FUNCTION__);
	}

	public static function MYSQL()
	{
		return self::getInstance(__FUNCTION__);
	}

	public static function SQLITE()
	{
		return self::getInstance(__FUNCTION__);
	}
}
 
