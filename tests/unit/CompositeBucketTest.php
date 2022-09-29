<?php

declare(strict_types=1);

namespace hiqdev\yii\DataMapper\tests\unit;

use hiqdev\DataMapper\Attribution\CompositeBucket;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class CompositeBucketTest extends TestCase
{
    private function getTestUsers(): array
    {
        return [
            ['client_id' => 1, 'currency' => 'usd'],
            ['client_id' => 2, 'currency' => 'eur'],
            ['client_id' => 3, 'currency' => 'usd'],
            ['client_id' => 3, 'currency' => 'eur'],
            ['client_id' => 4, 'currency' => 'pln'],
            ['client_id' => 4, 'currency' => 'eur'],
        ];
    }

    private function getTestBills(): array
    {
        return [
            ['id' => 1001, 'client_id' => 1, 'currency' => 'usd', 'amount' => 100],
            ['id' => 1002, 'client_id' => 1, 'currency' => 'usd', 'amount' => 200],
            ['id' => 1003, 'client_id' => 2, 'currency' => 'eur', 'amount' => 300],
            ['id' => 1004, 'client_id' => 3, 'currency' => 'usd', 'amount' => 400],
            ['id' => 1005, 'client_id' => 3, 'currency' => 'eur', 'amount' => 500],
            ['id' => 1006, 'client_id' => 4, 'currency' => 'pln', 'amount' => 600],
            ['id' => 1007, 'client_id' => 4, 'currency' => 'eur', 'amount' => 700],
        ];
    }

    public function testPrimaryUseCase()
    {
        $bucket = CompositeBucket::fromRows($this->getTestUsers(), ['client_id', 'currency']);
        $this->assertSame([1,2,3,4], $bucket->getKeys('client_id'));
        $this->assertSame(['usd', 'eur', 'pln'], $bucket->getKeys('currency'));

        $bills = $this->getTestBills();
        $bucket->fill($bills, ['client_id' => 'client_id', 'currency' => 'currency']);
        $bucket->pour($users, 'bills');

        foreach ($users as $user) {
            foreach ($user['bills'] as $key => $bill) {
                $this->assertLessThan(1000, $key);
                $this->assertSame($user['client_id'], $bill['client_id']);
                $this->assertSame($user['currency'], $bill['currency']);
            }
        }
    }

    public function testPourAsAssociativeArray(): void
    {
        $users = $this->getTestUsers();
        $bills = $this->getTestBills();

        $bucket = CompositeBucket::fromRows($users, ['client_id', 'currency']);
        $bucket->fill($bills, ['client_id' => 'client_id', 'currency' => 'currency'], 'id');
        $bucket->pour($users, 'bills');

        foreach ($users as $user) {
            foreach ($user['bills'] as $key => $bill) {
                $this->assertGreaterThan(1000, $key);
                $this->assertSame($user['client_id'], $bill['client_id']);
                $this->assertSame($user['currency'], $bill['currency']);
            }
        }
    }

    public function testGetKeysOnNonExistingKeyReturnsError(): void
    {
        $users = $this->getTestUsers();

        $bucket = CompositeBucket::fromRows($users, ['client_id', 'currency']);
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Key "non_existing_key" is not found in bucket');
        $bucket->getKeys('non_existing_key');
    }
}
