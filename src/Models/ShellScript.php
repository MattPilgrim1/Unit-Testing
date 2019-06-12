<?php
namespace App\Models;

use App\Interfaces\OutputInterface;

/**
 *
 */
class ShellScript implements OutputInterface
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
        $ext = self::extensionArray($extensionArray);

        return "find ".$originalPath. " -type f \( -iname \*.$ext \) -execdir mv -vn {} ".$outputPath." \;
";
    }

    public function extensionArray($extensionArray)
    {
        if (empty($extensionArray)) {
            return null;
        }

        return join($extensionArray, " -o -iname \\*.");
    }
}
