<?php
namespace Sklee\R;
use Sklee\R\R_Object;

class R_Is extends R_Object
{

    public function __construct($val)
    {
        parent::__construct($val);
    }

    public function is_date(string $format = 'Y-m-d'): bool
    {
        $d = DateTime::createFromFormat($format, $this->get());
        return $d && $d->format($format) === $this->get();
    }

    public function is_numeric(): bool
    {
        return is_numeric($this->get());
    }

    public function is_array(): bool
    {
        return is_array($this->get());
    }

    public function is_string(): bool
    {
        return is_string($this->get());
    }

    public function is_int(): bool
    {
        return is_int($this->get());
    }

    public function is_float(): bool
    {
        return is_float($this->get());
    }

    public function is_null(): bool
    {
        return empty($this->get());
    }

    public function is(): bool
    {
        return !!$this->get();
    }

    public function is_filter(int $filter)
    {
        return filter_var($this->get(), $filter);
    }

    public function is_ip(): bool
    {
        return $this->is_filter(FILTER_VALIDATE_IP);
    }

    public function is_domain(): bool
    {
        return $this->is_filter(FILTER_VALIDATE_DOMAIN);
    }

    public function is_email(): bool
    {
        return $this->is_filter(FILTER_VALIDATE_EMAIL);
    }

    public function is_url($val): bool
    {
        return $this->is_filter(FILTER_VALIDATE_URL);
    }

    public function is_phone(string $phone): bool
    {
        $pattern = "/^(?:\+82\s?|0)(?:2|[1-9][0-9])[- ]?\d{3,4}[- ]?\d{4}$/";
        return $this->is_match($pattern);
    }

    public function is_metch(string $metch): bool
    {
        return (bool)preg_match($metch, $this->get());
    }

    public function is_between($min, $max): bool
    {
        return $min <= $this->get() && $this->get() <= $max;
    }

    public function is_equal($val)
    {
        return $this->get() === $val;
    }

    public function is_error($value)
    {
        if (is_object($value)) {
            return false;
        }
        return $value instanceof \ParseError
            || $value instanceof \Error
            || $value instanceof \Throwable
            || $value instanceof \SoapFault
            || $value instanceof \DOMException
            || $value instanceof \PDOException;
    }


}