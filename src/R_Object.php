<?php
namespace Sklee\R;
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