<?php
namespace boundstate\importexport;

/**
 * Writes files.
 * @package boundstate\importexport
 */
abstract class BaseWriter extends \yii\base\Object
{
	/**
	 * @var ExportInterface|string exporter instance or class name
	 */
	public $source;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if (!$this->source) {
			throw new \yii\base\InvalidConfigException('The "source" property must be set.');
		}
		if (is_string($this->source)) {
			$this->source = new $this->source;
		}
	}

	/**
	 * Writes to a file.
	 * @return string filename
	 */
	public abstract function write();
}