<?php
namespace App;

use App\Models\Arrays;
use App\Models\ReturnFile;

/**
 *
 */
class File
{
    public function output()
    {
        $jsonFile = ReturnFile::returnJSONFile('./src/library.json');

        return array_merge_recursive(
            Arrays::returnArrayAsUppercase($jsonFile),
            Arrays::returnArrayAsLowercase($jsonFile)
        );
    }
}
