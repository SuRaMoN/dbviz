<?php

namespace DbViz\DbInfoExtractor\TableRelationExtractor;

use DbViz\Entity\ConnectionCredentials;
use DbViz\Entity\TableRelationCollection;
use PDO;


class SqlbaseTableRelationExtractor implements TableRelationExtractor
{
	public function getTableRelations(ConnectionCredentials $connectionCredentials)
	{
		$relations = new TableRelationCollection();

		$pdo = new PDO($connectionCredentials->getDsn(), $connectionCredentials->getUsername(), $connectionCredentials->getPassword());
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$relationStatement = $pdo->query('
			SELECT NAME, REFDTBNAME FROM SYSADM.SYSFKCONSTRAINTS
		');

		foreach($relationStatement->fetchAll(PDO::FETCH_OBJ) as $relation) {
			$relations->addRelation($relation->NAME, $relation->REFDTBNAME);
		}

		return $relations;
	}
}
 
