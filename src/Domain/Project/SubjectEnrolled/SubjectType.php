<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project\SubjectEnrolled;

enum SubjectType
{
    case CONTROL;
    case RECIPIENT;
}