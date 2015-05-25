<?php
namespace boundstate\importexport;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Shared_Date;

/**
 * Reads Excel files using PHPExcel.
 * @package boundstate\importexport
 */
class ExcelReader extends BaseReader
{
    /**
     * Reads from an Excel file.
     * @param string $filename
     */
	protected function read($filename)
    {
        $reader = PHPExcel_IOFactory::createReaderForFile($filename);
        $xl = $reader->load($filename);
        /* @var $xl \PHPExcel */

	    $sheet = $xl->getActiveSheet();

	    $this->rows = [];
	    foreach ($sheet->getRowIterator() as $row) {
		    $dataRow = [];
		    $cellIterator = $row->getCellIterator();
		    $cellIterator->setIterateOnlyExistingCells(false);
		    foreach ($cellIterator as $cell) {
			    if (PHPExcel_Shared_Date::isDateTime($cell)) {
				    // Convert Excel representations of dates to yyyy-MM-dd format
				    $dataRow[] = gmdate('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
			    } else {
				    $dataRow[] = $cell->getValue();
			    }
		    }
		    $this->rows[] = $dataRow;
	    }
    }
}