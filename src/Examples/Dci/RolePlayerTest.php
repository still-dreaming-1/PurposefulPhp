<?php
declare(strict_types=1);

namespace StillDreamingOne\PurposefulPhp\Examples\Dci;

final class RolePlayerTest extends \PHPUnit\Framework\TestCase
{
    public function testInjectAndCall()
    {
        $object = new RolePlayer();
        $injectedMethod = function() {
            return 5;
        };
        $object->getFive = $injectedMethod;
        $this->assertSame($object->getFive(), 5);
    }

    public function testInjectAndCallWithOneParam()
    {
        $object = new RolePlayer();
        $injectedMethod = function($add2To) {
            return $add2To + 2;
        };
        $object->add2To = $injectedMethod;
        $this->assertSame($object->add2To(1), 3);
    }

    public function testInjectAndCallWithTwoParams()
    {
        $object = new RolePlayer();
        $injectedMethod = function($first, $second) {
            return $first + $second;
        };
        $object->sum = $injectedMethod;
        $this->assertSame($object->sum(2, 7), 9);
    }
}
