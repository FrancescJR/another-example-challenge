<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project;

use Cesc\CMRad\Domain\Project\Exception\InvalidCollectionTypeException;
use Cesc\CMRad\Domain\Project\Exception\SubjectAlreadyEnrolledException;
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectEnrolled;
use TypeError;

final class SubjectsEnrolledList
{
    /**
     * @param SubjectEnrolled[] $subjects
     * @throws InvalidCollectionTypeException|SubjectAlreadyEnrolledException
     */
    public function __construct(private array $subjects)
    {
        try {
            foreach ($subjects as $subject) {
                $this->add($subject);
            }
        } catch (TypeError $typeError) {
            throw new InvalidCollectionTypeException(
                'SubjectEnrolledList only accepts SubjectEnrolled entities'
            );
        }
    }

    /**
     * @param SubjectEnrolled $subjectEnrolled
     * @return void
     * @throws SubjectAlreadyEnrolledException
     */
    public function add(SubjectEnrolled $subjectEnrolled): void
    {
        foreach ($this->subjects as $existingSubjectsEnrolled) {
            if ($existingSubjectsEnrolled->subjectId() === $subjectEnrolled->subjectId()) {
                throw new SubjectAlreadyEnrolledException(
                    sprintf("Subject %s already enrolled", $subjectEnrolled->subjectId()->value)
                );
            }
        }
        $this->subjects[] = $subjectEnrolled;
    }

    /**
     * @return SubjectEnrolled[]
     */
    public function subjects(): array
    {
        return $this->subjects;
    }

}