<?php
namespace App\Controllers;

use App\Models\Arrays;
use App\Models\ReturnFile;
use App\Models\CreateFile;
use App\Models\CommandLine\ShellScript;
use App\Models\CommandLine\PowerShell;
/**
 *
 */
class ReturnShellScript extends ScriptConstructor
{
    public function output()
    {
        $inputLocation = "D:/Downloads/";
        $outputLocation="D:/Sorted/";
        $recursive=5;
        $scriptType = new PowerShell;

        /*
         * Create Sub Directories into the output location
        */
        $shellScriptArray=self::script($inputLocation, $outputLocation, null, $scriptType);

        for ($i=1; $i <= 5; $i++) {
            $shellScriptArray.=self::script($inputLocation, $outputLocation, $i, $scriptType);
        }


        return CreateFile::unformatted('Output/run.ps1', $shellScriptArray);
    }
}
