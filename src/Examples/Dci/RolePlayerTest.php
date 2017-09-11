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
        $this->assertIsDciMissingMethodException($missingMethodName, $exception);
    }

    public function provideMissingMethodNames(): array
    {
        return [
            ['doIt'],
            /* ['tellAYourMomJoke'], */
        ];
    }

    private function assertIsDciMissingMethodException(string $methodName, $actualException)
    {
        $this->assertInstanceOf(DciException::class, $actualException);
        $this->assertSame($actualException->getMessage(), "Missing method $methodName");
    }

    /**
     * @dataProvider provideInjectMethodNamesAndReturnValues
     */
    public function testInjectAndCall(string $injectMethodName, $returnValue)
    {
        $this->object->injectMethod($injectMethodName, function () use ($returnValue) {
            return $returnValue;
        });
        $this->assertSame($this->object->$injectMethodName(), $returnValue);
    }

    public function provideInjectMethodNamesAndReturnValues(): array
    {
        return [
            ['getFive', 5],
            ['returnA', 'a'],
        ];
    }

    public function testInjectAndCallWithOneParam()
    {
        $this->object->injectMethod('add2To', function ($number) {
            return $number + 2;
        });
        $this->assertSame($this->object->add2To(1), 3);
    }

    public function testInjectAndCallWithTwoParams()
    {
        $this->object->injectMethod('sum', function ($first, $second) {
            return $first + $second;
        });
        $this->assertSame($this->object->sum(2, 7), 9);
    }

    public function testTryCallNonExistentMethodWhenUnrelatedPropertyOfSameNameExistsThrowsException()
    {
        $this->object->five = 5;
        $exception = null;
        try {
            $this->object->five();
        } catch (DciException $dciException) {
            $exception = $dciException;
        }
        $this->assertIsDciMissingMethodException('five', $exception);
    }
}
