<?php

declare(strict_types=1);

namespace Cesc\CMRad\Application\Project;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\CustomerRepository\Exception\InvalidCustomerRepositoryIdException;
use Cesc\CMRad\Domain\Project\Exception\InvalidProjectIdException;
use Cesc\CMRad\Domain\Project\ProjectId;
use Cesc\CMRad\Domain\Project\ProjectRepositoryInterface;
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectType;
use Cesc\CMRad\Domain\Subject\Exception\InvalidSubjectIdException;
use Cesc\CMRad\Domain\Subject\SubjectId;
use Cesc\CMRad\Domain\Subject\SubjectRepositoryInterface;

class EnrollSubjectCommandHandler
{
    public function __construct(
        private ProjectRepositoryInterface $projectRepository,
        private SubjectRepositoryInterface $subjectRepository
    ) {
    }

    /**
     * @param EnrollSubjectCommand $command
     * @return void
     * @throws ProjectNotFoundException
     * @throws SubjectNotFoundException
     * @throws InvalidCustomerRepositoryIdException
     * @throws InvalidProjectIdException
     * @throws InvalidSubjectIdException
     */
    public function __invoke(EnrollSubjectCommand $command): void
    {
        $project = $this->projectRepository->get(
            new ProjectId($command->projectId),
            new CustomerRepositoryId($command->customerRepositoryId)
        );

        if (!$project) {
            throw new ProjectNotFoundException();
        }
        $subjectId = new SubjectId($command->subjectId);
        $subject = $this->subjectRepository->get(
            $subjectId,
            new CustomerRepositoryId($command->customerRepositoryId)
        );

        if (!$subject) {
            throw new SubjectNotFoundException();
        }

        $project->enrollSubject($subjectId, SubjectType::from($command->subjectType));

        $this->projectRepository->save($project);
    }

}