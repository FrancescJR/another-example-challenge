<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectEnrolled;
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectType;
use Cesc\CMRad\Domain\Subject\SubjectId;

class Project
{
    private SubjectsEnrolledList $subjectsEnrolledList;

    /**
     * @param ProjectId $id
     * @param CustomerRepositoryId $customerRepositoryId
     * @throws Exception\InvalidCollectionTypeException|
     * @throws Exception\SubjectAlreadyEnrolledException
     */
    public function __construct(
        private ProjectId $id,
        private CustomerRepositoryId $customerRepositoryId
    ) {
        $this->subjectsEnrolledList = new SubjectsEnrolledList([]);
    }

    public function id(): ProjectId
    {
        return $this->id;
    }

    public function customerRepositoryId(): CustomerRepositoryId
    {
        return $this->customerRepositoryId;
    }

    public function subjectsEnrolled(): SubjectsEnrolledList
    {
        return $this->subjectsEnrolledList;
    }

    public function enrollSubject(SubjectId $subjectId, SubjectType $subjectType)
    {
        $this->subjectsEnrolledList->add(
            new SubjectEnrolled(
                $subjectId,
                $this->id,
                $subjectType
            )
        );
    }

}