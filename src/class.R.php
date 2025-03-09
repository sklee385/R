<?php
declare(strict_types=1);
namespace Remind;
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
            $is = R::is($type);
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

class R_Object
{
    protected $val;
    protected $before_val;
    protected static $instance = [];

    public function __construct($val)
    {
        $this->set($val);
    }

    public static function getInstance($val)
    {
        $class = static::class;
        if (empty(self::$instance[$class])) {
            self::$instance[$class] = new static($val);
        }

        self::$instance[$class]->set($val);;
        return self::$instance[$class];
    }

    public function set($val)
    {
        $this->before_val = $this->val;
        $this->val = $val;
        return $this;
    }

    public function get()
    {
        return $this->val;
    }

    public function get_before()
    {
        return $this->before_val;
    }

    public function property(string $path)
    {
        $keys = R::string($path)->split(".")->get();
        $item = $this->get();
        foreach ($keys as $key) {
            if (is_array($item) && array_key_exists($key, $item)) {
                $item = $item[$key]; // 배열 접근
            } elseif (is_object($item) && isset($item->$key)) {
                $item = $item->$key; // 객체 접근
            } else {
                return null; // 키가 없으면 null 반환 (안전 처리)
            }
        }
        return R::init($item);
    }

}








class R_Null extends R_Object
{
    public function __construct($val)
    {
        parent::__construct($val);
    }
}

class R_Boolean extends R_Object
{
    public function __construct($val)
    {
        parent::__construct($val);
    }
}


