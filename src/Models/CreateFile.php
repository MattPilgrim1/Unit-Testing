<?php
namespace App\Models;

/**
 *
 */
class CreateFile
{
    public $filename;
    public $contents;
    /**
     * Change the caseing of array values
     * @param string $filename - Parameter required for file_put_contents.
     * @param string $contents - contents of file being created.
     * @return float create file and populate with content
     */
    public function unformatted($filename, $contents)
    {
        return file_put_contents($filename, $contents);
    }
}
