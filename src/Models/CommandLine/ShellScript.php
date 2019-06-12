<?php
namespace App\Models\CommandLine;

use App\Models\Arrays;

/**
 *
 */
class ShellScript
{
    public $outputPath;
    public $extensionArray;
    public $originalPath;

    public function makeDirectory($outputPath)
    {
        return  "mkdir " . $outputPath . "
";
    }

    public function moveFile($originalPath, $outputPath, $extensionArray)
    {
        $ext = Arrays::joinArray($extensionArray, " -o -iname \\*.");

        return "find ".$originalPath. " -type f \( -iname \*.$ext \) -execdir mv -vn {} ".$outputPath." \;
";
    }
}
