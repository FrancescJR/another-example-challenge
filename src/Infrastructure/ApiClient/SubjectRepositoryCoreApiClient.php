<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\ApiClient;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\Subject\Subject;
use Cesc\CMRad\Domain\Subject\SubjectId;
use Cesc\CMRad\Domain\Subject\SubjectRepositoryInterface;

class SubjectRepositoryCoreApiClient implements SubjectRepositoryInterface
{

    public function get(SubjectId $subjectId, CustomerRepositoryId $customerRepositoryId): ?Subject
    {
        // TODO: Implement findById() method.
    }

    public function save(Subject $subject): void
    {
        // TODO: Implement save() method.
    }
}