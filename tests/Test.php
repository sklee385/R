<?php
use PHPUnit\Framework\TestCase;

class RTest extends TestCase
{
    public function test() {
        $name = "test";
        $this->assertEquals("test", $name);
    }
    public function test2() {
        $r = new \App\R_Object();
        $test = $r->test(1234);
        $this->assertEquals(1234, $test);

    }
}
