<?php
namespace App\Controllers;

use App\Models\ReturnFile;
use App\Models\CreateFile;
use App\Models\Arrays;
use App\Controllers\ScriptConstructor;
use App\Models\FileInformation;
/**
 *
 */
class ReturnJSONController
{

    protected function arraySetup($kindValue,$extensionValue)
    {
        $filename = "./Output/1/Raw/". $kindValue . "_" . $extensionValue . ".min.json";

        if( file_exists( $filename ) && !empty(ReturnFile::json($filename)) ){

            foreach ( ReturnFile::json($filename) as $fileInformation ) {

                            $length=0;

                            if(isset($fileInformation['Length']) === true)
                            {
                                $length = $fileInformation['Length'];
                            }


                            $extension[] = $length;


                }

                CreateFile::json('./Output/1/ScanResults/SortByExtension/'.$kindValue.'_'.$extensionValue.'.json',$extension);
            }



    }

    public function Kind($kindValue,$extensionArray)
    {
        $return=[];

        foreach ($extensionArray as $ext) {

            $returnFile = "./Output/1/ScanResults/SortByExtension/_".$ext.".json";

            if(file_exists($returnFile)){


                $returnData[$ext] = array_sum(ReturnFile::json($returnFile));

                CreateFile::json('./Output/1/ScanResults/SortByKind/_'.$kindValue.'.json',$returnData);

            }

        }

    }

    function __construct()
    {
        foreach (ScriptConstructor::arrayReturn() as $kind => $value) {

            foreach ($value as $ext) {

                self::arraySetup($kind,$ext);

            }

            self::Kind($kind,$value);
        }



    }

    public function view()
    {
        foreach (glob("./Output/1/ScanResults/SortByKind/_*.json") as $filename) {



            foreach (ReturnFile::json($filename) as $extension => $value) {

                $filesize[$filename][] = $value;

                $return[$filename][$extension] = FileInformation::formatSizeUnits($value);

            }

            $return2[$filename]=FileInformation::formatSizeUnits(array_sum($filesize[$filename]));

        }

        return [
                'ExtensionResults'=>$return,
                'KindResults'=>$return2
        ];


    }
}
