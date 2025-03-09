<?php
require_once "vendor/autoload.php";
use Sklee\R\R_Object;
use Sklee\R\R_Array;

$obj = new R_Object(new stdClass());
$arr = new R_Array([1,2,3]);
$_arr = $arr->map(function ($val ) {
    return $val ;
})->get();
print_r($_arr);