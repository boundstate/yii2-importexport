# yii2-importexport

  Extension for the Yii2 framework for importing and exporting data with [PHPExcel].

## Installation

  The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

  Either run

    php composer.phar require --prefer-dist boundstate/yii2-importexport "*"

  or add

    "boundstate/yii2-importexport": "*"

  to the require section of your `composer.json` file.

## Usage

  Implement the `ImportInterface` and/or `ExportInterface`:

    class Contact extends \yii\db\ActiveRecord implements ImportInterface, ExportInterface
    {
        ...

        public function import($reader, $row, $data)
    	{
    	    if ($row == 0) {
    	        if ($data != ['First Name', 'Last Name', 'Email']) {
    	            $reader->addError($row, 'Invalid headers.');
    	            return false;
    	        }
    	        // Skip header row
    	        return true;
    	    }

    	    // Create contact from data
    	    $contact = new Contact;
    	    ...
        }

        public function export() {
            return self::find()->asArray()->all();
        }
    }

  Now you can import data using `ExcelReader` and your class as the `destination`:

    public function actionImport()
    {
        $form = new ImportForm();
        $form->file = UploadedFile::getInstanceByName('file');

        if ($form->validate()) {
            Contact::deleteAll();
            $reader = new ExcelReader(['destination' => Contact::className()]);
            $reader->import($form->file->tempName);
            if ($reader->getErrors()) {
                // Handle errors
                ...
            }
        }
        return $form;
    }

  Or export data using `ExcelWriter` and your class as the `source`:

    public function actionExport()
    {
		$writer = new ExcelWriter(['source' => Contact::className()]);
        $filename = $writer->write('Excel2007');
        Yii::$app->response->sendFile($filename, 'contacts.xlsx')->send();
    }

[PHPExcel]: https://github.com/PHPOffice/PHPExcel