<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Subject;

use Cesc\CMRad\Domain\Subject\Exception\InvalidSubjectIdException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class SubjectId
{
    /**
     * @param string $value
     * @throws InvalidSubjectIdException
     */
    public function __construct(
        public readonly string $value
    ) {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidSubjectIdException(sprintf('Invalid uuid format for %s', $value));
        }
    }

    public function create()
    {
        RamseyUuid::uuid4()->toString();
    }

}