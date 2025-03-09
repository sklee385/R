<?php
namespace Sklee\R;
use Sklee\R\R;
use Sklee\R\R_Object;

class R_Array extends R_Object
{

    public function __construct(array $list)
    {
        parent::__construct($list);
    }

    public function map(callable $fn)
    {
        return $this->set(array_map($fn, $this->val, array_keys($this->val)));
    }

    public function filter(callable $fn)
    {
        return $this->set(array_filter($this->val, $fn, ARRAY_FILTER_USE_BOTH));
    }

    public function unfilter(callable $fn)
    {
        return $this->set(
            array_filter($this->get(), function ($val) use ($fn) {
                return !$fn($val);
            }, ARRAY_FILTER_USE_BOTH)
        );
    }

    public function reduce(callable $fn, $default_value)
    {
        $this->set(array_reduce($this->get(), $fn, $default_value));
        return $this;
    }

    public function each(callable $fn)
    {
        foreach ($this->get() as $index => $item) {
            $fn($item, $index);
        }
        return $this;
    }

    public function join(string $str)
    {
        return R::string(implode($str, $this->get()));
    }


    /**
     * 여러개 배열을 특정 키로 병합
     * @param string $join_key
     * @param array $list1
     * @param string $list2
     * @return array
     */
    public function array_join_merge(string $list2, string $join_key, $default_values = null)
    {
        $obj = $this->indexBy($join_key, $list2);
        $this->map(function ($item) use ($obj, $join_key, $default_values) {
            $pkey = $item[$join_key] ?: $default_values;
            return array_merge($item, $obj[$pkey]);
        });
        return $this;
    }

    /**
     * 두개의 리스트를 병합 하는데 해당 리스트를 하나의 키값에 넣는다.
     * $a = [ "a" => ['no' => 1, 'name' => "홍길동"];
     * $b = [ "a" => ['no' => 1, 'school' => "서울대"]
     * array_join_item('no', 'schools', $a, $b)
     * [ "a" => ['no' => 1, 'name' => "홍길동", "schools" => [ "a" => ['no' => 1, 'school' => "서울대"]]
     * @param string $join_key
     * @param string $item_key
     * @param array $list1
     * @param array $list2
     * @return array
     */
    public function array_join_item(array $list2, string $join_key, string $item_key)
    {
        $obj = $this->indexBy($join_key, $list2);
        $this->map(function ($item) use ($obj, $join_key, $item_key) {
            $pkey = $item[$join_key];
            $item[$item_key] = (array)$obj[$pkey];
            return $item;
        });
        return $this;
    }

    public function array_slice(int $offset, int $cnt)
    {
        $this->set(array_slice($this->get(), $offset, $cnt));
        return $this;
    }

    private function indexBy(string $key)
    {
        $this->set(array_combine(array_column($this->get(), $key), $this->get()));
        return $this;
    }

    public function array_fmap(callable $func)
    {
        $result = [];
        foreach ($this->get() as $item) {
            $result = array_merge($result, $func($item));
        }
        $this->set($result);
        return $this;
    }

    public function in_array($val)
    {
        return R::boolean(in_array($val, $this->get()));
    }

    public function chunk(int $num)
    {
        $this->set(array_chunk($this->get(), $num));
        return $this;
    }

    public function keys()
    {
        $this->set(array_keys($this->get()));
        return $this;
    }

    public function values()
    {
        $this->set(array_values($this->get()));
        return $this;
    }

    public function head()
    {

        return R::init($this->get()[0]);
    }

    public function tail()
    {
        $list = $this->get();
        return R::init(end($list));
    }

    public function merge(array $list)
    {
        return $this->set(array_merge($this->get(), $list));
    }

    public function cnt()
    {
        return R::init(count($this->get()));
    }

    public function all(callable $fn)
    {
        $result = count($this->filter($fn)) === $this->cnt();
        return R::init($result);
    }

    public function drop()
    {
        unset($this->get()[$this->cnt() - 1]);
        return $this;
    }

    public function push($val)
    {
        $this->get()[] = $val;
        return $this;
    }

    public function unshift($val)
    {
        $this->set(array_unshift($this->get(), $val));
        return $this;
    }

    public function unique()
    {
        $this->set(array_unique($this->get()));
        return $this;
    }

    public function diff(array $list)
    {
        $this->set(array_diff($this->get(), $list));
        return $this;
    }

    public function diff_r(array $list)
    {
        $this->set(array_diff($list, $this->get()));
        return $this;
    }

    public function reverse()
    {
        $this->set(array_reverse($this->get()));
        return $this;
    }

    public function json_encode()
    {
        $result = R::string(json_encode($this->get()));
        return $result;
    }

    public function find(callable $fn)
    {
        return $this->filter($fn)->head();
    }

    public function rand(int $num = 1)
    {
        return $this->set(array_rand($this->get(), $num));
    }

    public function pad(int $num)
    {
        return $this->set(array_pad($this->get(), $num));
    }

    public function arsort(int $flags = SORT_REGULAR)
    {
        return $this->set(
            arsort($this->get(), $flags)
        );
    }

    public function shuffle()
    {
        return $this->set(array_shuffle($this->get()));
    }


}