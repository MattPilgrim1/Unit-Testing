<?php
use PHPUnit\Framework\TestCase;

use App\Controllers\ReturnShellScript;
use App\Models\ReturnFile;
use App\Models\CreateFile;
use App\Models\Arrays;
use App\Controllers\ReturnJSONController;

class PowerShellOutputTest extends TestCase
{
    protected function setUp(): void
    {


        






        $this->filename= "./Output/1/Raw/Compressed_cab.min.json";

        $this->explode= explode("_",$this->filename);

        $this->returnKind = str_replace('./Output/1/Raw/',"",$this->explode[0]);

        $this->returnFileExtension = str_replace(".min.json","",$this->explode[1]);

        $this->returnFile = ReturnFile::json($this->filename);

        foreach ($this->returnFile as $fileInformation) {

            $this->returnFileSizeArray[]=$fileInformation['Length'];

            $this->returnFilePathArray[]= str_replace("\\","/",$fileInformation['FullName']);
            // code...
        }

        CreateFile::json('./Output/1/ScanResults/SortByExtension/Filesize/cab.min.json',$this->returnFileSizeArray);

        CreateFile::json('./Output/1/ScanResults/SortByExtension/Filename/cab.min.json',$this->returnFilePathArray);

        $this->countTest = array_sum($this->returnFileSizeArray);

        $this->SortByKindArray['cab']=$this->countTest;

        $IJR6WH4='$IJR6WH4';

        $this->JSONTestOutput = [[
            "FullName"=>"D:\\Unsorted\\Library\\Compressed\\cab\\1\\container.cab",
            "Extension"=>".cab",
            "Length"=> 95
        ], [
            "FullName"=> "D:\\Unsorted\\Library\\Compressed\\cab\\1\\$IJR6WH4.cab",
            "Extension"=> ".cab",
            "Length"=> 140
        ]];

        $this->testBackSlash = str_replace("\\","/","D:\\Unsorted\\Library\\Compressed\\cab\\1\\container.cab");


    }

    public function testReturnAllFilesWithinDirectory()
    {
        $this->assertTrue(is_array($this->glob));
    }

    public function testReturnExampleFileInDirectory()
    {
        $this->assertEquals($this->glob[0],"./Output/1/Raw/Compressed_cab.min.json");
    }

    public function testReturnExplodeFilename()
    {

        $this->assertEquals($this->explode,['./Output/1/Raw/Compressed','cab.min.json']);
    }

    public function testReturnKindFromFilename()
    {
        $this->assertEquals($this->returnKind,'Compressed');
    }

    public function testReturnFileExtensionfromFileName()
    {
        $this->assertEquals($this->returnFileExtension,'cab');
    }

    public function testReturnJSONFile()
    {
        $this->assertEquals($this->returnFile,$this->JSONTestOutput);
    }

    public function testReplaceBackslashwithForwardSlash()
    {
        $this->assertEquals($this->testBackSlash,"D:/Unsorted/Library/Compressed/cab/1/container.cab");
    }

    public function testReturnFileSizeOnlyFromJSON()
    {
        $this->assertEquals($this->returnFileSizeArray,[95,140]);
    }

    public function testReturnFileNameOnlyFromJSON()
    {
        $IJR6WH4='$IJR6WH4';

        $this->assertEquals($this->returnFilePathArray,["D:/Unsorted/Library/Compressed/cab/1/container.cab","D:/Unsorted/Library/Compressed/cab/1/$IJR6WH4.cab"]);
    }

    public function testReturnCountResult()
    {
        $this->assertEquals($this->countTest,235);
    }

    public function testReturnSortByKind()
    {
        $this->assertEquals($this->SortByKindArray,['cab'=>235]);
    }

}
