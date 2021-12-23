<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;

final class Project
{

    public function __construct(
        private ProjectId $id,
        private CustomerRepositoryId $customerRepositoryId
    )
    {

    }

    public function id():ProjectId
    {
        return $this->id;
    }

    public function customerRepositoryId(): CustomerRepositoryId
    {
        return $this->customerRepositoryId;
    }

}