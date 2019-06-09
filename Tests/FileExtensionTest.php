<?php
use PHPUnit\Framework\TestCase;

use App\File;
use App\Controllers;
use App\Models\ReturnFile;
use App\Models\Arrays;

class FileExtensionTest extends TestCase
{
    public function testDirectoryExists()
    {
        $this->assertDirectoryExists('./src/');
    }

    public function testFileExists()
    {
        $this->assertFileExists('./src/library.json');
    }

    public function testReturnedFileIsJSON()
    {
        $jsonDecode = ReturnFile::returnJSONFile('./src/library.json');

        $jsonLastError = json_last_error() == JSON_ERROR_NONE;

        $this->assertTrue($jsonLastError);
    }

    public function testReturnKindKeyFromArray()
    {
        $jsonDecode = ReturnFile::returnJSONFile('./src/library.json');

        foreach ($jsonDecode as $key => $value) {
            $this->assertTrue(is_string($key));
        }
    }

    public function testReturnFileExtensionValueFromArray()
    {
        $jsonDecode = ReturnFile::returnJSONFile('./src/library.json');

        foreach ($jsonDecode as $fileExtension) {
            $this->assertTrue(is_array($fileExtension));
        }
    }

    public function testFileExtensionsAreInLowerCase()
    {
        $jsonDecode = ReturnFile::returnJSONFile('./src/library.json');

        $library = Arrays::returnArrayAsLowercase($jsonDecode);

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
        $jsonDecode = ReturnFile::returnJSONFile('./src/library.json');

        $library = Arrays::returnArrayAsUppercase($jsonDecode);

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

    public function testReturnUpperAndLowerCaseExtensionArray()
    {
        $arrayReturn=File::arrayReturn();

        $this->assertTrue(is_array($arrayReturn));
    }

    public function testFilePutContentsResultIsComplete()
    {
        $this->assertEquals(File::Output(), 9642);
    }

    public function testOutput()
    {

        //var_dump();
    }
}
