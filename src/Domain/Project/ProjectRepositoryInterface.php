<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;

interface ProjectRepositoryInterface
{
    public function get(ProjectId $projectId, CustomerRepositoryId $customerRepositoryId): ?Project;

    public function save(Project $project): void;

}