<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project\SubjectEnrolled;

use Cesc\CMRad\Domain\Project\ProjectId;
use Cesc\CMRad\Domain\Subject\SubjectId;

final class SubjectEnrolled
{
    public function __construct(
        private SubjectId $subjectId,
        private ProjectId $projectId,
        private SubjectType $subjectType
    )
    {

    }

}