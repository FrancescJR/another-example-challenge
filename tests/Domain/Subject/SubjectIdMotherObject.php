<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Subject;

use Cesc\CMRad\Domain\Subject\Exception\InvalidSubjectIdException;
use Cesc\CMRad\Domain\Subject\SubjectId;
use Faker\Factory;

final class SubjectIdMotherObject
{
    public const DEFAULT_ID = "e5c26a25-553f-35e8-acb6-e89a635aefb6";

    /**
     * @param string|null $value
     * @return SubjectId
     * @throws InvalidSubjectIdException
     */
    public function create(?string $value = null): SubjectId
    {
        return new SubjectId($value ?? Factory::create()->uuid);
    }
}