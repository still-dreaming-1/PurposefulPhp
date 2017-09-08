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

    /**
     * @dataProvider provideMissingMethodNames
     */
    public function testCallMissingMethodThrowsException(string $missingMethodName)
    {
        $exception = null;
        try {
            $this->object->$missingMethodName();
        } catch (DciException $dciException) {
            $exception = $dciException;
        }
        $this->assertIsDciException("Missing method $missingMethodName", $exception);
    }

    public function provideMissingMethodNames(): array
    {
        return [
            ['doIt'],
            ['tellAYourMomJoke'],
        ];
    }

    private function assertIsDciException(string $expectedMessage, $actualException)
    {
        $this->assertInstanceOf(DciException::class, $actualException);
        $this->assertSame($actualException->getMessage(), $expectedMessage);
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
