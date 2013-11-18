<?php

namespace DbViz\Constant;

use DbViz\DbVizTestCase;


class DbDriverTest extends DbVizTestCase
{
	/** @test */
	public function testDbDriver()
	{
		$mysql = DbDriver::MYSQL();
		$sqlite = DbDriver::SQLITE();

		$this->assertTrue($mysql instanceof DbDriver);

		$this->assertTrue($mysql === DbDriver::MYSQL());
		$this->assertTrue($mysql == DbDriver::MYSQL());

		$this->assertTrue($sqlite !== DbDriver::MYSQL());
		$this->assertTrue($sqlite != DbDriver::MYSQL());
	}

	/** @test */
	public function testSwitchCase()
	{
		$isMysql = false;
		switch(DbDriver::MYSQL())
		{
			case DbDriver::MYSQL():
				$isMysql = true;
				break;
			case DbDriver::SQLITE():
				$isMysql = false;
				break;
		}
		$this->assertTrue($isMysql);
	}

	/** @test */
	public function testToString()
	{
		$this->assertEquals('MYSQL', (string) DbDriver::MYSQL());
	}
}

