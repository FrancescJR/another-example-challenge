<?php

declare(strict_types=1);

namespace Cesc\CMRad\Application\Subject;

class CreateSubjectCommand
{
    public function __construct(
        public readonly string $subjectId,
        public readonly string $customerRepositoryId
    ) {
    }

}