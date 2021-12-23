<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Project\SubjectEnrolled;

use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectEnrolled;
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectType;
use Cesc\CMRad\Tests\Domain\Project\ProjectIdMotherObject;
use Cesc\CMRad\Tests\Domain\Subject\SubjectIdMotherObject;
use PHPUnit\Framework\TestCase;

class SubjectEnrolledTest extends TestCase
{
    public function testConstructor()
    {
        $subjectId = SubjectIdMotherObject::create();
        $projectId = ProjectIdMotherObject::create();
        $subjectEnrolled = new SubjectEnrolled(
            $subjectId,
            $projectId,
            SubjectType::CONTROL
        );
        self::assertEquals($subjectId, $subjectEnrolled->subjectId());
        self::assertEquals($projectId, $subjectEnrolled->projectId());
        self::assertEquals(SubjectType::CONTROL, $subjectEnrolled->subjectType());
    }

}