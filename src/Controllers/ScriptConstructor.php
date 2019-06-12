<?php
namespace App\Controllers;

use App\Models\Arrays;
use App\Models\ReturnFile;
use App\Models\CreateFile;
use App\Models\CommandLine\ShellScript;

/**
 *
 */
class ScriptConstructor
{
    public $inputLocation;
    public $outputLocation;
    public $recursive;

    public function script($inputLocation, $outputLocation, $recursive, $scriptObject)
    {
        $moveFile=$makeDirectory=$createPresetFiles=null;

        foreach (self::arrayReturn() as $kind => $extensionArray) {
            if (empty($recursive)) {
                $createPresetFiles .= $scriptObject::makeDirectory($outputLocation.$kind);
            }


            if (isset($recursive)) {
                $outputPath=$outputLocation.$kind."/".$recursive;

                $makeDirectory.=$scriptObject::makeDirectory($outputPath);

                $moveFile.=$scriptObject::moveFile($inputLocation, $outputPath, $extensionArray);
            }
        }

        return $createPresetFiles. $makeDirectory . $moveFile;
    }

    public function arrayReturn()
    {
        $jsonFile = ReturnFile::returnJSONFile('./src/library.json');

        return array_merge_recursive(
            Arrays::returnArrayAsUppercase($jsonFile),
            Arrays::returnArrayAsLowercase($jsonFile)
        );
    }
}
