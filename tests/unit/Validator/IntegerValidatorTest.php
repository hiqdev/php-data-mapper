<?php declare(strict_types=1);

namespace hiqdev\DataMapper\tests\unit\Validator;

use hiqdev\DataMapper\Validator\IntegerValidator;
use PHPUnit\Framework\TestCase;

class IntegerValidatorTest extends TestCase
{
    private IntegerValidator $validator;

    public function setUp(): void
    {
        $this->validator = new IntegerValidator();
    }

    /**
     * @dataProvider numericValuesProvider
     * Test the normalize method with numeric values.
     */
    public function testNormalizeWithNumericValues($input, $expected): void
    {
        $this->assertSame($expected, $this->validator->normalize($input));
    }

    /**
     * Data provider for numeric values.
     *
     * @return array
     */
    public function numericValuesProvider(): iterable
    {
        yield 'integer as string' => ['123', 123];
        yield 'integer as integer' => [123, 123];
        yield 'negative integer' => ['-45', -45];
        yield 'zero as string' => ['0', 0];
        yield 'zero as integer' => [0, 0];
    }

    /**
     * @dataProvider nonNumericValuesProvider
     * Test the normalize method with non-numeric values.
     */
    public function testNormalizeWithNonNumericValues($input): void
    {
        $this->assertNull($this->validator->normalize($input));
    }

    /**
     * Data provider for non-numeric values.
     *
     * @return array
     */
    public function nonNumericValuesProvider(): iterable
    {
        yield 'string with letters' => ['abc'];
        yield 'empty array' => [[]];
        yield 'null value' => [null];
        yield 'boolean false' => [false];
        yield 'boolean true' => [true];
    }
}
