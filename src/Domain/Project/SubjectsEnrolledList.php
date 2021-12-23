<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project;

use Cesc\CMRad\Domain\Project\Exception\InvalidCollectionTypeException;
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectEnrolled;

final class SubjectsEnrolledList
{
    /**
     * @param array $subjects
     * @throws InvalidCollectionTypeException
     */
    public function __construct(private array $subjects)
    {
        try {
            foreach($subjects as $subject) {
                $this->add($subject);
            }
        } catch(\TypeError $typeError) {
            throw new InvalidCollectionTypeException(
                'SubjectEnrolledList only accepts SubjectEnrolled entities'
            );
        }


    }

    public function add(SubjectEnrolled $subjectEnrolled):void
    {
        $this->subjects[] = $subjectEnrolled;
    }

    public function subjects(): array
    {
        return $this->subjects;
    }

}