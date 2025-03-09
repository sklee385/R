<?php
namespace Sklee\R;
use Sklee\R\R_Boolean;
use Sklee\R\R_Null;
use Sklee\R\R_Object;

class R
{
    public static function array(array $list = [])
    {
        return R_Array::getInstance($list);
    }
    public function test(string $str) {
        return $str;
    }‰

    public static function is($val)
    {
        return R_Is::getInstance($val);
    }

    public static function string(string $str)
    {
        return R_String::getInstance($str);
    }

    public static function number(int $val)
    {
        return R_Number::getInstance($val);
    }

    public static function null($val)
    {
        return R_Null::getInstance($val);
    }

    public static function object($val)
    {
        return R_Object::getInstance($val);
    }

    public static function boolean($val)
    {
        return R_Boolean::getInstance($val);
    }

    public static function type($val): string
    {
        $type = gettype($val);
        $obj = [
            "boolean" => "boolean",
            "number" => "number",
            "integer" => "number",
            "double" => "number",
            "float" => "number",
            "string" => "string",
            "array" => "array",
            "object" => "object",
            "resource" => "resource",
            "resource (closed)" => "resource",
            "NULL" => "null",
            "datetime" => "datetime"
        ];
        if ($obj[$type] === "string") {
            $is = \Remind\R::is($type);
            if ($is->is_date() || $is->is_date("Y-m-d H:i:s")) {
                $type = "datetime";
            }
        }

        return $obj[$type] ?: "null";
    }

    public static function init($val)
    {
        $type = self::type($val);
        if ($type === "array") {
            return self::array($val);
        }
        if ($type === "number") {
            return self::number($val);
        }

        if ($type === "boolean") {
            return self::boolean($val);
        }
        if ($type === "object") {
            return self::object($val);
        }

        if ($type === "string") {
            return self::string($val);
        }
        return self::null($val);
    }
}