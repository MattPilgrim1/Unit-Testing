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
    public function output()
    {
        $inputLocation = "/Users/matt/Desktop/";
        $outputLocation="/Users/matt/Public/";
        $recursive=5;
        $scriptType = new ShellScript;

        /*
         * Create Sub Directories into the output location
        */
        $shellScriptArray=self::script($inputLocation, $outputLocation, null, $scriptType);

        for ($i=1; $i <= 5; $i++) {
            $shellScriptArray.=self::script($inputLocation, $outputLocation, $i, $scriptType);
        }


        return CreateFile::unformatted('Demo/run.sh', $shellScriptArray);
    }
}
