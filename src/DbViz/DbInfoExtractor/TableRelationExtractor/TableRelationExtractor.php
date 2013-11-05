<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\Entity\ConnectionCredentials;


interface TableRelationExtractor
{
	public function getTableRelations(ConnectionCredentials $connectionCredentials);
}
 
