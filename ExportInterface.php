<?php
namespace boundstate\importexport;

interface ExportInterface
{
	/**
	 * @return array data to export
	 */
	public function export();
}