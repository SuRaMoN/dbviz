<?php

namespace DbViz\DbInfoExtractor;


class ExtractorSet
{
	protected $driver;
	protected $tableSizeExtractorFactory;
	protected $tableRelationExtractorFactory;

	public function __construct(
		TableRelationExtractorFactory $tableRelationExtractorFactory,
		TableSizeExtractorFactory $tableSizeExtractorFactory,
		$driver)
	{
		$this->driver = $driver;
		$this->tableSizeExtractorFactory = $tableSizeExtractorFactory;
		$this->tableRelationExtractorFactory = $tableRelationExtractorFactory;
	}

	public function getTableRelationExtractor()
	{
		return $this->tableRelationExtractorFactory->getForDriver($this->driver);
	}

	public function getTableSizeExtractor()
	{
		return $this->tableSizeExtractorFactory->getForDriver($this->driver);
	}
}
 
