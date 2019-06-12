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
    public function arrayReturn()
    {
        $jsonFile = ReturnFile::returnJSONFile('./src/library.json');

        return array_merge_recursive(
            Arrays::returnArrayAsUppercase($jsonFile),
            Arrays::returnArrayAsLowercase($jsonFile)
        );
    }
}
