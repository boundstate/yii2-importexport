<?php
namespace boundstate\importexport;

interface ImportInterface
{
	/**
	 * Process a row (typically import the row to a database).
	 * @param BaseReader $reader
	 * @param integer $row zero-based row number
	 * @param array $data row data
	 */
	public function import($reader, $row, $data);
}