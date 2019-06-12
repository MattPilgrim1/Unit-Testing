<?php
namespace App\Controllers;

use App\Models\Arrays;
use App\Models\ReturnFile;
use App\Models\CreateFile;
use App\Models\CommandLine\ShellScript;

/**
 *
 */
class ReturnShellScript extends ScriptConstructor
{
    public $inputLocation;
    public $outputLocation;
    public $recursive;

    public function script($inputLocation, $outputLocation, $recursive)
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

    public function output()
    {
        $inputLocation = "/Users/matt/Desktop/";
        $outputLocation="/Users/matt/Public/";
        $recursive=5;

        /*
         * Create Sub Directories into the output location
        */
        $shellScriptArray=self::script($inputLocation, $outputLocation, null);

        for ($i=1; $i <= 5; $i++) {
            $shellScriptArray.=self::script($inputLocation, $outputLocation, $i);
        }


        return CreateFile::unformatted('Demo/run.sh', $shellScriptArray);
    }
}
