<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project\SubjectEnrolled;

enum SubjectType: string
{
    case CONTROL = 'control';
    case RECIPIENT = 'recipient';
}