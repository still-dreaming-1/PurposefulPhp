<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp\Examples\Dci;

final class RolePlayerTest extends \PHPUnit\Framework\TestCase
{
    private $object;

    public function setup()
    {
        $this->object = new RolePlayer();
    }

    public function testInjectAndCall()
    {
        $injectedMethod = function() {
            return 5;
        };
        $this->object->getFive = $injectedMethod;
        $this->assertSame($this->object->getFive(), 5);
    }

    public function testInjectAndCallWithOneParam()
    {
        $injectedMethod = function($add2To) {
            return $add2To + 2;
        };
        $this->object->add2To = $injectedMethod;
        $this->assertSame($this->object->add2To(1), 3);
    }

    public function testInjectAndCallWithTwoParams()
    {
        $injectedMethod = function($first, $second) {
            return $first + $second;
        };
        $this->object->sum = $injectedMethod;
        $this->assertSame($this->object->sum(2, 7), 9);
    }
}
