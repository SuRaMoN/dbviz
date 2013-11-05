<?php

namespace DbViz\DbInfoExtractor\TableSizeExtractor;

use DbViz\Entity\ConnectionCredentials;


interface TableSizeExtractor
{
	public function getTableSizes(ConnectionCredentials $connectionCredentials);
}
 
