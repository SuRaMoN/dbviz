<?php

namespace DbViz;

use DbViz\DbVizContainer;
use DbViz\Ui\DbVizConsole;
use PDO;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\StreamOutput;


abstract class DbVizTestCase extends PHPUnit_Framework_TestCase
{
	protected $temporaryFiles = array();

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

