<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\ApiClient;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\Project\Project;
use Cesc\CMRad\Domain\Project\ProjectId;
use Cesc\CMRad\Domain\Project\ProjectRepositoryInterface;

class ProjectRepositoryCoreApiClient implements ProjectRepositoryInterface
{

    public function get(ProjectId $projectId, CustomerRepositoryId $customerRepositoryId): ?Project
    {
        // TODO: Implement findById() method.
    }

    public function save(Project $project): void
    {
        // TODO: Implement save() method.
    }
}