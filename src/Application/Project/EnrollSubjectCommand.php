<?php

declare(strict_types=1);

namespace Cesc\CMRad\Application\Project;

class EnrollSubjectCommand
{
    public function __construct(
        public readonly string $projectId,
        public readonly string $customerRepositoryId,
        public readonly string $subjectId,
        public readonly string $subjectType
    ) {
    }

}