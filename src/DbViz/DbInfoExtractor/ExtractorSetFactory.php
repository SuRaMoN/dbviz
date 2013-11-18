<?php

namespace DbViz\DbInfoExtractor;


class ExtractorSetFactory
{
	protected $tableSizeExtractorFactory;
	protected $tableRelationExtractorFactory;

	public function __construct(
		TableRelationExtractorFactory $tableRelationExtractorFactory,
		TableSizeExtractorFactory $tableSizeExtractorFactory)
	{
		$this->tableSizeExtractorFactory = $tableSizeExtractorFactory;
		$this->tableRelationExtractorFactory = $tableRelationExtractorFactory;
	}

	public function getForDriver($driver)
	{
		return new ExtractorSet(
			$this->tableRelationExtractorFactory,
			$this->tableSizeExtractorFactory,
			$driver
		);
	}
}
 
