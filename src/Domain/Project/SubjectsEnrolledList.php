<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project;

final class SubjectsEnrolledList
{
    public function __construct(public readonly array $subjects)
    {

    }

}