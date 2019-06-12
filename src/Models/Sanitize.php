<?php
namespace App\Models;

/**
 *
 */
class Sanitize
{
    public $string;

    public function string(string $string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

    public function integer(string $string)
    {
        return filter_var($string, FILTER_SANITIZE_NUMBER_INT);
    }
}
