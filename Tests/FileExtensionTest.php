<?php
use PHPUnit\Framework\TestCase;

use App\Controllers\ReturnShellScript;
use App\Models\ReturnFile;
use App\Models\Arrays;

class FileExtensionTest extends TestCase
{
    protected function setUp(): void
    {
        $this->testArrayFormat=[
            'Documents'=>[
                'doc',
                'xls'
            ]
        ];

        $this->fileDirectory = './src/';

        $this->fileName = $this->fileDirectory .'library.json';

        $this->array = ReturnFile::returnJSONFile($this->fileName);
    }

    public function testDirectoryExists()
    {
        $this->assertDirectoryExists($this->fileDirectory);
    }

    public function testFileExists()
    {
        $this->assertFileExists($this->fileName);
    }

    public function testReturnedFileIsJSON()
    {
        $this->array;

        $jsonLastError = json_last_error() == JSON_ERROR_NONE;

        $this->assertTrue($jsonLastError);
    }

    public function testReturnKindKeyFromArray()
    {
        foreach ($this->array as $key => $value) {
            $this->assertTrue(is_string($key));
        }
    }

    public function testReturnFileExtensionValueFromArray()
    {
        foreach ($this->array as $fileExtension) {
            $this->assertTrue(is_array($fileExtension));
        }
    }


    public function testFileExtensionsAreInLowerCase()
    {
        $library = Arrays::returnArrayAsLowercase($this->array);

        foreach ($library as $fileKind => $extensionArray) {
            foreach ($extensionArray as $fileExtension) {
                if (preg_match('/[0-9]/', $fileExtension) || preg_match('/[a-z]/', $fileExtension)) {
                    $this->assertTrue(true);
                } else {
                    throw new \Exception("Incorrect file extension: ".$fileExtension, 1);
                    $this->assertTrue(false);
                }
            }
        }
    }

    public function testFileExtensionsAreAlsoReturnedUpperCase()
    {
        $library = Arrays::returnArrayAsUppercase($this->array);

        foreach ($library as $fileKind => $extensionArray) {
            foreach ($extensionArray as $fileExtension) {
                if (preg_match('/[0-9]/', $fileExtension) || preg_match('/[A-Z]/', $fileExtension)) {
                    $this->assertTrue(true);
                } else {
                    throw new \Exception("Incorrect file extension: ".$fileExtension, 1);
                    $this->assertTrue(false);
                }
            }
        }
    }

    public function testFilePutContentsResultIsComplete()
    {
        $this->assertNotEquals(ReturnShellScript::output(), false);
    }
}
