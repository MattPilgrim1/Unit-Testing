<?php
namespace App\Controllers;

use App\Models\CreateFile;
use App\Models\CommandLine\ShellScript;
use App\Models\CommandLine\PowerShell;
use App\Models\ReturnFile;
use App\Models\FileInformation;
/**
 *
 */
class ReturnShellScript extends ScriptConstructor
{
    public function __construct($mainPath)
    {
        CreateFile::directory($mainPath . '/Raw');
        CreateFile::directory($mainPath . '/ScanResults/SortByExtension');
        CreateFile::directory($mainPath . '/ScanResults/SortByFileSize');
        CreateFile::directory($mainPath . '/View/SortByExtension');
        CreateFile::directory($mainPath . '/View/SortByFileSize');
    }

    public function output()
    {
        $inputLocation = "/Users/matt/Desktop/";
        $outputLocation="/Users/matt/Public/";
        $recursive=1;


        /*
         * Create Sub Directories into the output location
        */
        $powershellScriptArray=self::script($inputLocation, $outputLocation, null, new PowerShell);

        $powershellScriptArray.=self::script($inputLocation, $outputLocation, $recursive, new PowerShell);

        CreateFile::unformatted('Output/run.ps1', $powershellScriptArray);

        $shellScriptArray=self::script($inputLocation, $outputLocation, null, new ShellScript);

        $shellScriptArray.=self::script($inputLocation, $outputLocation, $recursive, new ShellScript);

        CreateFile::unformatted('Output/run.sh', $shellScriptArray);

    }

    public function arrayMappingExtensionAndFileSize($kind,$filepath)
    {

        $return= ReturnFile::returnJSONFile( $filepath . '/'.$kind.'.min.json');

        foreach ($return as $key => $value) {


                $fileExtension = $value['Extension'];

                if(isset($value['Length']))
                {
                    $length = $value['Length'];
                }
                else{
                    $length = 0;
                }


                $arrayReturnFirstResult[$fileExtension][]=$length;
                $arrayReturnViewResult[$fileExtension][]=FileInformation::formatSizeUnits($length);



        }

        CreateFile::json(  $filepath . '/ScanResults/SortByFileSize/'.$kind.'.min.json',$arrayReturnFirstResult);
        CreateFile::json(  $filepath . '/View/SortByFileSize/'.$kind.'.min.json',$arrayReturnViewResult);

        foreach ($arrayReturnFirstResult as $extension => $listedFleSizes) {

            $arrayAccumilateReturn[$extension] =array_sum($listedFleSizes);



        }

        foreach ($arrayAccumilateReturn as $fileExtension => $fileSize) {
            // code...
            $sortByExtension[$fileExtension]=FileInformation::formatSizeUnits($fileSize);

        }

        CreateFile::json( $filepath . '/View/SortByExtension/'.$kind.'.min.json',$sortByExtension);


        CreateFile::json( $filepath . '/ScanResults/SortByExtension/'.$kind.'.min.json',$arrayAccumilateReturn);


    }
}
