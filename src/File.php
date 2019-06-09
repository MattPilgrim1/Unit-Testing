<?php
namespace App;

use App\Models\Arrays;
use App\Models\ReturnFile;
use App\Powershell;
use App\ShellScript;

/**
 *
 */
class File
{
    public function arrayReturn()
    {
        $jsonFile = ReturnFile::returnJSONFile('./src/library.json');

        return array_merge_recursive(
            Arrays::returnArrayAsUppercase($jsonFile),
            Arrays::returnArrayAsLowercase($jsonFile)
        );
    }

    public function shellScript($inputLocation, $outputLocation, $recursive)
    {
        $moveFile=$makeDirectory=null;

        foreach (self::arrayReturn() as $kind => $extensionArray) {
            $outputPath=$outputLocation.$kind."/".$recursive;

            $makeDirectory.=ShellScript::makeDirectory($outputPath);

            $moveFile.=ShellScript::moveFile($inputLocation, $outputPath, $extensionArray);
        }

        return $makeDirectory . $moveFile;
    }

    public function Output()
    {
        $inputLocation = "/Users/matt/Public/";
        $outputLocation="/Users/matt/Desktop/";
        $recursive=5;

        return file_put_contents('Output/run.sh', self::shellScript($inputLocation, $outputLocation, $recursive));
    }
}
