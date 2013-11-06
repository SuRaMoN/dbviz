<?php

namespace DbViz;

use DbViz\DbVizContainer;
use DbViz\Entity\ConnectionCredentials;
use DbViz\Ui\DbVizConsole;
use PDO;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\StreamOutput;


abstract class DbVizTestCase extends PHPUnit_Framework_TestCase
{
	protected $temporaryFiles = array();

	protected function getConfig()
	{
		$configPath = __DIR__ . '/../config/dbviz.ini';
		if(! file_exists($configPath)) {
			return array();
		}
	    return parse_ini_file($configPath, true);
	}

	protected function createContainer()
	{
	    return new DbVizContainer();
	}

	protected function createApplication()
	{
	    return new DbVizConsole($this->createContainer());
	}

	protected function runCommand($name)
	{
		$args = func_get_args();
		$command = $this->createApplication()->find($name);
		$input = new ArgvInput(array_merge(array(''), $args));
		$memoryFileHandle = fopen('php://memory', 'r+');
		$output = new StreamOutput($memoryFileHandle);
		$command->run($input, $output);
		rewind($memoryFileHandle);
		return stream_get_contents($memoryFileHandle);
	}

	protected function createSqliteDbFromSqlFile($sqlFilePath)
	{
		$tmpFile = $this->createTemporaryFile();
		$pdo = new PDO("sqlite:$tmpFile");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec(file_get_contents($sqlFilePath));
		return $tmpFile;
	}

	protected function skipIfNoOdbcDriver()
	{
		if(! in_array('odbc', PDO::getAvailableDrivers())) {
			$this->markTestSkipped('Skipped because no odbc driver installed');
		}
	}
	
	protected function skipIfNoMysql()
	{
		$config = $this->getConfig();
		if(! array_key_exists('MySQL', $config)) {
			$this->markTestSkipped('Skipped because no MySQL instance configured');
		}
	}
	
	protected function getMysqlCredentials()
	{
		$config = $this->getConfig();
		$myConfig = $config['MySQL'];
		return new ConnectionCredentials("mysql:host={$myConfig['host']};dbname={$myConfig['database']}", $myConfig['username'], $myConfig['password']);
	}

	protected function getMysqlPDO()
	{
		$credentials = $this->getMysqlCredentials();
		$pdo = new PDO($credentials->getDsn(), $credentials->getUsername(), $credentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}

	protected function dropAllMysqlDatabaseTables(PDO $pdo)
	{
		$pdo->exec('SET foreign_key_checks = 0');
		foreach($pdo->query('show tables')->fetchAll(PDO::FETCH_COLUMN) as $table) {
			$pdo->exec("drop table `$table`");
		}
		$pdo->exec('SET foreign_key_checks = 1');
	}
	

	protected function createMysqlDbFromSqlFile($sqlFilePath)
	{
		$pdo = $this->getMysqlPDO();
		$this->dropAllMysqlDatabaseTables($pdo);
		foreach(explode(';', file_get_contents($sqlFilePath)) as $query) {
			if(trim($query) != '') {
				$pdo->exec($query);
			}
		}
		return $pdo;
	}

	public function createTemporaryFile()
	{
		$tmpFile = tempnam(sys_get_temp_dir(), 'db-viz-test-');
		$this->temporaryFiles[] = $tmpFile;
		return $tmpFile;
	}

	public function __destruct()
	{
		foreach($this->temporaryFiles as $file) {
			if(is_file($file)) {
				unlink($file);
			}
		}
	}
}

