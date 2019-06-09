<?php
namespace App\Models;

/**
 *
 */
class Arrays
{
    public $caseType;
    public $array;


    /**
     * Change the caseing of array values
     * @param string $caseType - Parameter required for array_map.
     * @param array $array - Requested array that requires caseing change.
     * @return float array entirely uppercase
     */
    public function arrayCaseing($caseType, $array)
    {
        foreach ($array as $key => $value) {
            $return[$key] = array_map($caseType, $value);
        }

        return $return;
    }

    /**
     * Change the caseing of array values
     * @param array $array - Requested array that requires caseing change.
     * @return float array values in uppercase
     */
    public function returnArrayAsUppercase($array)
    {
        return self::arrayCaseing('strtoupper', $array);
    }

    /**
     * Change the caseing of array values
     * @param array $array - Requested array that requires caseing change.
     * @return float array values in lowercase
     */
    public function returnArrayAsLowercase($array)
    {
        return self::arrayCaseing('strtolower', $array);
    }
}
