<?php
use PHPUnit\Framework\TestCase;

use App\Controllers\ReturnJSONController;

class testReturnFileSizeOnlyFromJSON extends TestCase
{
    public function testJSONReturn()
    {
        new ReturnJSONController;

        print_r(ReturnJSONController::view());
    }

}
