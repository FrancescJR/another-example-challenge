<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Subject;

use Cesc\CMRad\Domain\Subject\Exception\InvalidSubjectIdException;
use Cesc\CMRad\Domain\Subject\SubjectId;
use PHPUnit\Framework\TestCase;

class SubjectIdTest extends TestCase
{
    public function testConstruct(): void
    {
        $subjectId = new SubjectId(SubjectIdMotherObject::DEFAULT_ID);
        self::assertEquals(SubjectIdMotherObject::DEFAULT_ID, $subjectId->value);
    }

    public function testInvalidValue(): void
    {
        self::expectException(InvalidSubjectIdException::class);
        new SubjectId("not a uuid");
    }

}