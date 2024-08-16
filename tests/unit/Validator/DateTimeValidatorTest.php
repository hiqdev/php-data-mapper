<?php

namespace hiqdev\DataMapper\tests\unit\Validator;

use hiqdev\DataMapper\Validator\DateTimeValidator;
use PHPUnit\Framework\TestCase;
use yii\base\Model;

class DateTimeValidatorTest extends TestCase
{
    public function setUp(): void
    {
        $this->validator = new DateTimeValidator();
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testValueValidation($date, $expectedErrorMessage = null)
    {
        $model = $this->createModel();
        $model->date = $date;
        $this->validator->validateAttribute($model, 'date');
        if ($expectedErrorMessage) {
            $this->assertArrayHasKey('date', $model->getErrors());
            $this->assertSame($expectedErrorMessage, $model->getFirstError('date'));
        } else {
            $this->assertEmpty($model->getErrors());
        }
        $this->assertSame($date, $model->date);
    }

    public function valuesProvider(): array
    {
        return [
            'date w/o TZ' => ['2024-08-16T12:45:05'],
            'date w/ TZ' => ['2024-08-16T12:45:05+00:00'],
            'date' => ['2024-08-16'],
            'invalid date' => ['not a date', 'The format of Date is invalid.'],
        ];
    }

    public function createModel(): Model
    {
        return new class() extends Model {
            public $date;
        };
    }
}
