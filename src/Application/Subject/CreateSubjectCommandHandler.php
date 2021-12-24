<?php

declare(strict_types=1);

namespace Cesc\CMRad\Application\Subject;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\CustomerRepository\Exception\InvalidCustomerRepositoryIdException;
use Cesc\CMRad\Domain\Subject\Exception\InvalidSubjectIdException;
use Cesc\CMRad\Domain\Subject\Subject;
use Cesc\CMRad\Domain\Subject\SubjectId;
use Cesc\CMRad\Domain\Subject\SubjectRepositoryInterface;

class CreateSubjectCommandHandler
{
    public function __construct(
        private SubjectRepositoryInterface $subjectRepository
    ) {
    }

    /**
     * @param CreateSubjectCommand $command
     * @return void
     * @throws InvalidCustomerRepositoryIdException
     * @throws InvalidSubjectIdException
     * @throws SubjectAlreadyExistsException
     */
    public function __invoke(CreateSubjectCommand $command): void
    {
        $subjectId = new SubjectId($command->subjectId);
        $customerRepositoryId = new CustomerRepositoryId($command->customerRepositoryId);

        $subject = $this->subjectRepository->get($subjectId, $customerRepositoryId);

        if ($subject) {
            throw new SubjectAlreadyExistsException();
        }

        $subject = new Subject(
            $subjectId,
            $customerRepositoryId
        );

        $this->subjectRepository->save($subject);
    }

}