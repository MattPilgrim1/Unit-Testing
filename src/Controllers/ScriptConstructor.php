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
    public $inputLocation;
    public $outputLocation;
    public $recursive;

    public function newScript($inputLocation,$outputLocation,$recursive, $scriptObject)
    {
        $return=null;

        foreach (self::arrayReturn() as $kind => $extensionArray) {

            foreach ($extensionArray as $key => $ext) {
                // code...
                $return.="Get-ChildItem " . $inputLocation . "/* -Recurse -Include ('*.$ext') | select FullName,Extension,length | ConvertTo-Json -Compress | Add-Content -Path ".$outputLocation."/".$kind."_".$ext.".min.json
";
            }

            //$ext = Arrays::joinArray($extensionArray, "', '*.");





        }

        return $return;
    }

    public function script($inputLocation, $outputLocation, $recursive, $scriptObject)
    {
        $moveFile=$makeDirectory=$createPresetFiles=$createExtensionDirectory=$fileExtensionArray=null;

        foreach (self::arrayReturn() as $kind => $extensionArray) {
            if (empty($recursive)) {
                $createPresetFiles .= $scriptObject::makeDirectory($outputLocation.$kind);
            }

            foreach ($extensionArray as $fileExtension) {



                if (preg_match('/[0-9]/', $fileExtension) || preg_match('/[a-z]/', $fileExtension)) {



                    if (empty($recursive)) {
                        $createExtensionDirectory .= $scriptObject::makeDirectory($outputLocation.$kind."/".$fileExtension);
                    }

                    if(isset($recursive))
                    {
                        $fileExtensionArray =self::returnFileExtension($fileExtension);

                        $outputPath=$outputLocation.$kind."/".$fileExtension."/".$recursive;

                        $makeDirectory.=$scriptObject::makeDirectory($outputPath);

                        $moveFile.=$scriptObject::moveFile($inputLocation, $outputPath, $fileExtensionArray);
                    }
                }




            }
        }

        return $createPresetFiles. $createExtensionDirectory.$makeDirectory . $moveFile;
    }



    public function returnFileExtension($fileExtension)
    {
            return [strtolower($fileExtension),strtoupper($fileExtension)];
    }

    public function arrayReturn()
    {
        $jsonFile = ReturnFile::returnJSONFile('./src/advanced.json');

        return array_merge_recursive(
            //Arrays::returnArrayAsUppercase($jsonFile),
            Arrays::returnArrayAsLowercase($jsonFile)
        );
    }
}
