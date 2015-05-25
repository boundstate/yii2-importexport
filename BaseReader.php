<?php
namespace boundstate\importexport;

/**
 * Reads files.
 * @package boundstate\importexport
 */
abstract class BaseReader extends \yii\base\Object
{
	/**
	 * @var ImportInterface|string importer instance or class name
	 */
	public $destination;

	/**
	 * @var array data
	 */
	public $rows = [];

	/**
	 * @var array import errors
	 */
	private $_errors = [];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if (!$this->destination) {
			throw new \yii\base\InvalidConfigException('The "destination" property must be set.');
		}
		if (is_string($this->destination)) {
			$this->destination = new $this->destination;
		}
	}

	/**
	 * Adds an error.
	 * @param integer $row
	 * @param mixed $message
	 */
	public function addError($row, $message) {
		$this->_errors[] = ['row'=>$row, 'message'=>$message];
	}

	/**
	 * @return array row errors
	 */
	public function getErrors() {
		return $this->_errors;
	}

	/**
	 * Imports data via the configured importer.
	 * @param string $filename
	 * @return bool
	 */
	public function import($filename) {
		$this->_errors = [];
		$this->read($filename);

		foreach ($this->rows as $i => $row) {
			if (!$this->destination->import($this, $i, $row)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Reads from a file.
	 * @param string $filename
	 */
	protected abstract function read($filename);
}