<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\CustomerRepository;

use Cesc\CMRad\Domain\CustomerRepository\Exception\InvalidCustomerRepositoryIdException;
use Ramsey\Uuid\Uuid;

final class CustomerRepositoryId
{
    /**
     * @param string $value
     * @throws InvalidCustomerRepositoryIdException
     */
    public function __construct(
        public readonly string $value
    ) {
        if (!Uuid::isValid($value)) {
            throw new InvalidCustomerRepositoryIdException(sprintf('Invalid uuid format for %s', $value));
        }
    }

}