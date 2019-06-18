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
        if(file_exists($filename)){

            return false;

        }
        return file_put_contents($filename, $contents);
    }

    public function json($filename, $contents)
    {
        $contents = json_encode($contents);

        return self::unformatted($filename, $contents);
    }

    public function directory($filepath)
    {
        if(is_dir($filepath)){
            return false;
        }

        return mkdir($filepath, 0777, true);
    }
}
