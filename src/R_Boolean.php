<?php

namespace Sklee\R;
use Sklee\R\R_Object;
class R_Boolean extends R_Object
{
    public function __construct(bool $val)
    {
        parent::__construct($val);
    }
}