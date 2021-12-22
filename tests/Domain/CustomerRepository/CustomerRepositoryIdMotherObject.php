<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\CustomerRepository;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\CustomerRepository\Exception\InvalidCustomerRepositoryIdException;
use Faker\Factory;

final class CustomerRepositoryIdMotherObject
{
    public const DEFAULT_ID = "9066f75d-43e1-3966-a068-769b985cc047";

    /**
     * @param string|null $value
     * @return CustomerRepositoryId
     * @throws InvalidCustomerRepositoryIdException
     */
    public static function create(?string $value = null): CustomerRepositoryId
    {
        return new CustomerRepositoryId($value ?? Factory::create()->uuid);
    }

}