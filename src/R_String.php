<?php
namespace Sklee\R;

use Sklee\R\R_Object;

class R_String extends R_Object
{
    public function __construct($str)
    {
        parent::__construct($str);
    }

    public function split(string $char)
    {
        $this->set(explode($char, $this->get()));
        return $this;
    }

    /**
     * 첫 번쨰 글자 대문자
     */
    public function first_upper()
    {
        return $this->set(
            ucfirst($this->get())
        );
    }

    public function upper()
    {
        return $this->set(strtoupper($this->get()));
    }

    /**
     * 첫 글자 소문자
     */
    public function first_lowper()
    {
        return $this->set(
            lcfirst($this->get())
        );
    }

    public function lower()
    {
        return $this->set(strtolower($this->get()));
    }

    /**
     * "&", "<", ">", '"' 및 "'" 문자를 해당 문자로 변환
     */
    public function escape()
    {
        return $this->set(
            htmlspecial($this->get(), ENT_QUOTES | ENT_HTML5, "UTF-8")
        );
    }

    public function remove_html(string $str)
    {
        return $this->set(
            strip_tags($this->get(), $str)
        );
    }

    public function pad(int $num, string $str, int $pad_style = STR_PAD_LEFT)
    {
        return $this->set(
            str_pad($this->get(), $num, $str, $pad_style)
        );
    }

    /**
     * 문자 반복
     */
    public function repeat(int $num)
    {
        return $this->set(
            str_repeat($this->get(), $num)
        );
    }

    public function replace(string $pattern, string $trans_str)
    {
        return $this->set(
            str_replace($pattern, $trans_str, $this->get())
        );
    }
}
