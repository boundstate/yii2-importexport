<?php
namespace boundstate\importexport;

use PHPExcel;
use PHPExcel_IOFactory;

/**
 * Writes Excel files using PHPExcel.
 * @package boundstate\importexport
 */
class ExcelWriter extends BaseWriter
{
	/**
     * Writes to an Excel file.
	 * @param string $writerType PHPExcel writer type
     * @return string filename
     */
    public function write($writerType = 'Excel2007') {
	    $exporter = $this->source;
        $filename = \Yii::$app->runtimePath . '/' . uniqid() . '.xlsx';

        $xl = new PHPExcel();
        $sheet = $xl->getSheet(0);

        // Sheet headers
        foreach ($exporter->getExportHeaders() as $colNum => $header) {
            $sheet->setCellValueByColumnAndRow($colNum, 1, $header);
        }

        // Sheet rows
        foreach ($exporter->export() as $rowNum => $row) {
            foreach ($row as $colNum => $value) {
                $sheet->setCellValueByColumnAndRow($colNum, $rowNum + 2, $value);
            }
        }

        $writer = PHPExcel_IOFactory::createWriter($xl, $writerType);
        $writer->save($filename);

        return $filename;
    }
}