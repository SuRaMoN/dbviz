<?php

namespace DbViz\DbVisualizator;

use DbViz\Entity\TableRelationCollection;


class DotDbVisualizator
{
	public function __construct()
	{
	}

	public function getString(TableRelationCollection $relations, array $tableSizeMap)
	{
		$fileHandle = fopen('php://memory', 'r+');
		$this->writeByFileHandle($fileHandle, $relations, $tableSizeMap);
		rewind($fileHandle);
		$dotString = stream_get_contents($fileHandle);
		fclose($fileHandle);
		return $dotString;
	}

	public function writeByFilePath($filePath, TableRelationCollection $relations, array $tableSizeMap)
	{
		$fileHandle = fopen($filePath, 'w');
		$this->writeByFileHandle($fileHandle, $relations, $tableSizeMap);
		fclose($fileHandle);
	}

	public function writeByFileHandle($fileHandle, TableRelationCollection $relations, array $tableSizeMap)
	{
		fputs($fileHandle, "graph DbVisualization {\n");
		foreach($tableSizeMap as $table => $size) {
			fputs($fileHandle, "\t\"" . addslashes($table) . "\" [size = {$tableSizeMap[$table]}]\n");
		}
		foreach($relations->getUndirectedRelations() as $relation) {
			list($from, $to) = $relation;
			fputs($fileHandle, "\t\"" . addslashes($from) . "\" -- \"" . addslashes($to) . "\"\n");
		}
		fputs($fileHandle, "}\n");
	}
}
 
