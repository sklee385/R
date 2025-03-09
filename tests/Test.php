<?php
use PHPUnit\Framework\TestCase;

class RTest extends TestCase
{
    public function test() {
        $name = "test";
        $this->assertEquals("test", $name);
    }
    public function test2() {
        $r = Sklee\R\R_Object::getInstance(new stdClass());

//        $this->assertEquals(1234, $test);

    }
}
