<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Subject;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;

interface SubjectRepositoryInterface
{
    public function get(SubjectId $subjectId, CustomerRepositoryId $customerRepositoryId): ?Subject;

    public function save(Subject $subject): void;

}