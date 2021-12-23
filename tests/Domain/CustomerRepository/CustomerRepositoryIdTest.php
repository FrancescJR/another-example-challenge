<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\CustomerRepository;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\CustomerRepository\Exception\InvalidCustomerRepositoryIdException;
use PHPUnit\Framework\TestCase;

class CustomerRepositoryIdTest extends TestCase
{
    public function testConstruct(): void
    {
        $repositoryId = new CustomerRepositoryId(CustomerRepositoryIdMotherObject::DEFAULT_ID);
        self::assertEquals(CustomerRepositoryIdMotherObject::DEFAULT_ID, $repositoryId->value);
    }

    public function testInvalidValue(): void
    {
        self::expectException(InvalidCustomerRepositoryIdException::class);
        new CustomerRepositoryId("not a uuid");
    }

}