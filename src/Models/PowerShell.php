<?php
namespace App\Models;

use App\Interfaces\OutputInterface;

/**
 *
 */
class PowerShell implements OutputInterface
{
    public $outputPath;
    public $extensionArray;
    public $originalPath;



    public function makeDirectory($outputPath)
    {
        return 'New-Item -Path "'.$outputPath.'" -ItemType "directory"';
    }

    public function moveFile($originalPath, $outputPath, $extensionArray)
    {
        $ext = self::extensionArray($extensionArray);

        return "Get-ChildItem $originalPath\* -Include ('*.$ext') -Recurse | Move-Item -Destination '".$outputPath."' ";
    }

    public function extensionArray($extensionArray)
    {
        if (empty($extensionArray)) {
            return null;
        }

        return join($extensionArray, "', '*.");
    }
}
