<?php
namespace App\Models\CommandLine;

use App\Interfaces\OutputInterface;
use App\Models\Arrays;

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
        $ext = Arrays::joinArray($extensionArray, "', '*.");

        return "Get-ChildItem $originalPath\* -Include ('*.$ext') -Recurse | Move-Item -Destination '".$outputPath."' ";
    }
}
