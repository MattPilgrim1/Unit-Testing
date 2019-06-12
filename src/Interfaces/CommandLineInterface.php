<?php
namespace App\Interfaces;

/**
 *
 */
interface CommandLineInterface
{
    public function script($inputLocation, $outputLocation, $recursive);

    public function output();
}
