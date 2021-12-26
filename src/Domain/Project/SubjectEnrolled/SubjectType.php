<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project\SubjectEnrolled;

use Cesc\CMRad\Domain\Project\Exception\InvalidSubjectTypeException;

enum SubjectType: string
{
    case CONTROL = 'control';
    case RECIPIENT = 'recipient';

    /**
     * @param string $string
     * @return static
     * @throws InvalidSubjectTypeException
     */
    public static function fromString(string $string):self
    {
        $subjectType = self::tryFrom($string);

        if (!$subjectType) {
            throw new InvalidSubjectTypeException();
        }

        return $subjectType;
    }
}