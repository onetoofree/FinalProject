<?php
require '/Library/WebServer/Documents/project/tests/sum.php';
use PHPUnit\Framework\TestCase;

class testTest extends TestCase
{
    public function testTrueAssertsToTrue()
    {
        $this->assertTrue(true);
    }

    public function testSumHappy()
    {
        $a = 7;
        $this-> assertTrue(sum(3,4) == $a);
    }

    public function testSumSad()
    {
        $a = 7;
        $this-> assertFalse(sum(3,2) == $a);
    }
}
?>