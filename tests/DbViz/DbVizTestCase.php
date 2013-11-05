<?php

namespace DbViz;

use PDO;
use PHPUnit_Framework_TestCase;


abstract class DbVizTestCase extends PHPUnit_Framework_TestCase
{
	protected $temporaryFiles = array();

	protected function createSqliteDbFromSqlFile($sqlFilePath)
	{
		$tmpFile = $this->getTemporaryFileName();
		$pdo = new PDO("sqlite:$tmpFile");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec(file_get_contents($sqlFilePath));
		return $tmpFile;
	}

	public function getTemporaryFileName()
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

