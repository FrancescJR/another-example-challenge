<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\ApiClient;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\CustomerRepository\Exception\InvalidCustomerRepositoryIdException;
use Cesc\CMRad\Domain\Project\Exception\InvalidCollectionTypeException;
use Cesc\CMRad\Domain\Project\Exception\InvalidProjectIdException;
use Cesc\CMRad\Domain\Project\Exception\SubjectAlreadyEnrolledException;
use Cesc\CMRad\Domain\Project\Project;
use Cesc\CMRad\Domain\Project\ProjectId;
use Cesc\CMRad\Domain\Project\ProjectRepositoryInterface;

class ProjectRepositoryCoreApiClient extends CoreServiceApiClient implements ProjectRepositoryInterface
{
    public const GET_PROJECT = self::BASE_ENDPOINT . '/projects/%projectId';
    public const POST_PROJECT = self::BASE_ENDPOINT . '/projects';

    /**
     * @param ProjectId $projectId
     * @param CustomerRepositoryId $customerRepositoryId
     * @return Project|null
     * @throws CoreServiceException
     * @throws InvalidCustomerRepositoryIdException
     * @throws InvalidCollectionTypeException
     * @throws InvalidProjectIdException
     * @throws SubjectAlreadyEnrolledException
     */
    public function get(ProjectId $projectId, CustomerRepositoryId $customerRepositoryId): ?Project
    {
        $coreServiceProject = $this->request(
            'GET',
            sprintf($this->baseUrl . self::GET_PROJECT, $customerRepositoryId->value, $projectId->value)
        );
        return $coreServiceProject ? new Project(
            new ProjectId($coreServiceProject['id']),
            new CustomerRepositoryId($coreServiceProject['customer_repository_id'])
        ) : null;
    }

    public function save(Project $project): void
    {
        // TODO: Implement save() method.
    }
}