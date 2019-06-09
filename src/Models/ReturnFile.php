<?php
namespace App\Models;

/**
 *
 */
class ReturnFile
{
    /**
     * Change the caseing of array values
     * @param string $filename - Parameter required for file_get_contents.
     * @return float convert JSON file to array
     */
    public function returnJSONFile($filename)
    {
        $fileGetContents = file_get_contents($filename);

        return json_decode($fileGetContents);
    }
}
