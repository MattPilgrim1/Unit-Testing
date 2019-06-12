<?php
namespace App\Interfaces;

/**
 *
 */
interface OutputInterface
{
    public function makeDirectory($outputPath);

    public function moveFile($originalPath, $outputPath, $extensionArray);
}
