<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Subject;

final class Subject
{
    public function __construct(
        private SubjectId $id,
        private SubjectType $type
    )
    {

    }

    public function id(): SubjectId
    {
        return $this->id;
    }

    public function type(): SubjectType
    {
        return $this->type;
    }

}