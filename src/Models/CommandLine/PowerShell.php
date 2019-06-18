<?php
namespace App\Models\CommandLine;

use App\Models\Arrays;

/**
 *
 */
class PowerShell
{
    public $outputPath;
    public $extensionArray;
    public $originalPath;


    public function makeDirectory($outputPath)
    {
        return 'New-Item -Path "'.$outputPath.'" -ItemType "directory"
';
    }

    public function moveFile($originalPath, $outputPath, $extensionArray)
    {
        $ext = Arrays::joinArray($extensionArray, "', '*.");

        return "Get-ChildItem $originalPath* -Include ('*.$ext') -Recurse | Move-Item -Destination '".$outputPath."'
";
    }

    public function exportCSV($outputPath)
    {
        return "| Export-Csv $outputPath";
    }

    public function getChildItemList()
    {

        return "Get-ChildItem D:/* -Recurse | Export-Csv C:/inetpub/wwwroot/Unit-Testing/Output/LibraryList.csv
";

    }
}
