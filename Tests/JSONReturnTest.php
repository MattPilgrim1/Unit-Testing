<?php
use PHPUnit\Framework\TestCase;

use App\Controllers\ScriptConstructor;
use App\Models\CommandLine\PowerShell;
use App\Models\CreateFile;
use App\Models\ReturnFile;
use App\Controllers\ReturnShellScript;
use App\Models\FileInformation;


class JSONReturnTest extends TestCase
{
    protected function setUp(): void
    {


        $this->uid = 1;

        $this->mainPath = 'C:/inetpub/wwwroot/Unit-Testing/Output/'.$this->uid;

        new ReturnShellScript($this->mainPath);



    }
    public function testReturnJSONFile()
    {

        $inputLocation = "D:";
        $outputLocation= $this->mainPath ."/Raw";
        $recursive=1;
        $scriptObject = new PowerShell;

        $powershellScriptArray = ScriptConstructor::newScript($inputLocation, $outputLocation, $recursive, $scriptObject);

        CreateFile::unformatted($this->mainPath . "/run.ps1", $powershellScriptArray);


    }

    public function testReturnLibraryList()
    {
        $jsonFile = ReturnFile::returnJSONFile('./src/advanced.json');

        foreach ($jsonFile as $kind => $value) {

            $arrayReturn[$kind] = ReturnShellScript::arrayMappingExtensionAndFileSize($kind, $this->mainPath);

        }

    }

    public function testOutputScan()
    {
        $jsonFile = ReturnFile::returnJSONFile('./src/advanced.json');

        foreach ($jsonFile as $kind => $value) {

            $arrayReturn[$kind]=ReturnFile::returnJSONFile($this->mainPath . '/ScanResults/SortByExtension/'.$kind.'.min.json');


        }

        //Output as Library Filesize totals

        foreach ($arrayReturn as $kind => $fileSizeArray) {

            $library[$kind] = array_sum($fileSizeArray);


            // code...
        }

        foreach ($library as $kind => $size) {
            // code...

            $library2[$kind] = FileInformation::formatSizeUnits($size);

        }

        CreateFile::json( $this->mainPath . '/View/Library.json',$library2);

        // Entire Overall Filesize Totals

        CreateFile::json( $this->mainPath . '/ScanResults/Total.json',array_sum($library));

        CreateFile::json( $this->mainPath . '/View/Total.json',FileInformation::formatSizeUnits(array_sum($library)));




    }

}
