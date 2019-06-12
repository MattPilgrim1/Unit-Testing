<?php
namespace App\Controllers;

use App\Models\Arrays;
use App\Models\ReturnFile;
use App\Models\CreateFile;
use App\Models\CommandLine\Powershell;
use App\Models\CommandLine\ShellScript;

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
        $moveFile=$makeDirectory=$createPresetFiles=null;

        foreach (self::arrayReturn() as $kind => $extensionArray) {
            if (empty($recursive)) {
                $createPresetFiles .= ShellScript::makeDirectory($outputLocation.$kind);
            }


            if (isset($recursive)) {
                $outputPath=$outputLocation.$kind."/".$recursive;

                $makeDirectory.=ShellScript::makeDirectory($outputPath);

                $moveFile.=ShellScript::moveFile($inputLocation, $outputPath, $extensionArray);
            }
        }

        return $createPresetFiles. $makeDirectory . $moveFile;
    }

    public function Output()
    {
        $inputLocation = "/Users/matt/Desktop/";
        $outputLocation="/Users/matt/Public/";
        $recursive=5;

        /*
         * Create Sub Directories into the output location
        */
        $shellScriptArray=self::shellScript($inputLocation, $outputLocation, null);

        for ($i=1; $i <= 5; $i++) {
            $shellScriptArray.=self::shellScript($inputLocation, $outputLocation, $i);
        }


        return CreateFile::unformatted('Demo/run.sh', $shellScriptArray);
    }
}
