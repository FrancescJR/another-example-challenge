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
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectEnrolled;

class ProjectRepositoryCoreApiClient extends CoreServiceApiClient implements ProjectRepositoryInterface
{
    public const GET_PROJECT = self::BASE_ENDPOINT . '/projects/%projectId';
    public const ENROLL_SUBJECT = self::BASE_ENDPOINT . '/projects/%projectId/subjects/%subjectId';

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

    /**
     * @param Project $project
     * @return void
     * @throws CoreServiceException
     */
    public function save(Project $project): void
    {
        foreach($project->subjectsEnrolled() as $subjectEnrolled) {
            $this->enrollProjectOnCoreService($project->customerRepositoryId()->value, $subjectEnrolled);
        }
    }

    /**
     * @param string $customerRepositoryId
     * @param SubjectEnrolled $subjectEnrolled
     * @return void
     * @throws CoreServiceException
     */
    public function enrollProjectOnCoreService(string $customerRepositoryId, SubjectEnrolled $subjectEnrolled): void
    {
        $this->request(
            'POST',
            sprintf($this->baseUrl . self::ENROLL_SUBJECT,
                    $customerRepositoryId,
                    $subjectEnrolled->projectId()->value,
                    $subjectEnrolled->subjectId()->value
            ),
            json_encode(['subject_type' => $subjectEnrolled->subjectType()->value])
        );
    }
}