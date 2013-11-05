<?php

namespace DbViz\Entity;


class TableRelationCollection
{
	protected $relations;

	public function __construct()
	{
		$this->relations = array();
	}

	public function addRelation($from, $to)
	{
		if(! array_key_exists($from, $this->relations)) {
			$this->relations[$from] = array();
		}
		$this->relations[$from][$to] = true;
	}

	public function hasRelation($from, $to)
	{
		return array_key_exists($from, $this->relations) && array_key_exists($to, $this->relations[$from]);
	}

	public function getUndirectedRelations()
	{
		$relations = array();
		foreach($this->relations as $from => $tos) {
			foreach($tos as $to => $v) {
				if($from < $to) {
					$relations[] = array($from, $to);
				} else {
					$relations[] = array($to, $from);
				}
			}
		}
		$relations = array_map('unserialize', array_unique(array_map('serialize', $relations)));
		return $relations;
	}

	public function getRelations()
	{
		$relations = array();
		foreach($this->relations as $from => $tos) {
			foreach($tos as $to => $v) {
				$relations[] = array($from, $to);
			}
		}
		return $relations;
	}
}
 
