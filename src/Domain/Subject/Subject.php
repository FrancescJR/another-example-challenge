<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Subject;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;

final class Subject
{
    public function __construct(
        private SubjectId $id,
        private CustomerRepositoryId $customerRepositoryId
    )
    {

    }

    public function id(): SubjectId
    {
        return $this->id;
    }


    public function customerRepositoryId():CustomerRepositoryId
    {
        return $this->customerRepositoryId;
    }

}