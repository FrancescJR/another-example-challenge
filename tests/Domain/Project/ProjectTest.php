<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Project;

use Cesc\CMRad\Domain\Project\Project;
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectType;
use Cesc\CMRad\Domain\Project\SubjectsEnrolledList;
use Cesc\CMRad\Domain\Subject\SubjectId;
use Cesc\CMRad\Tests\Domain\CustomerRepository\CustomerRepositoryIdMotherObject;
use Cesc\CMRad\Tests\Domain\Subject\SubjectIdMotherObject;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    public function testConstruct(): void
    {
        $projectId = ProjectIdMotherObject::create();
        $customerRepositoryId = CustomerRepositoryIdMotherObject::create();
        $project = new Project(
            $projectId,
            $customerRepositoryId
        );

        self::assertEquals($projectId, $project->id());
        self::assertEquals($customerRepositoryId, $project->customerRepositoryId());
        self::assertCount(0, $project->subjectsEnrolled()->subjects());
    }

    public function testEnrollSubject(): void
    {
        $project = ProjectMotherObject::create();
        $recipientSubjectId = SubjectIdMotherObject::create();
        $controlSubjectId = SubjectIdMotherObject::create();

        $project->enrollSubject($recipientSubjectId, SubjectType::RECIPIENT);
        $project->enrollSubject($controlSubjectId, SubjectType::CONTROL);

        self::assertCount(2, $project->subjectsEnrolled()->subjects());

        self::assertTrue($this->assertContainsSubject($project->subjectsEnrolled(), $recipientSubjectId));
        self::assertTrue($this->assertContainsSubject($project->subjectsEnrolled(), $controlSubjectId));
    }

    private function assertContainsSubject(SubjectsEnrolledList $list, SubjectId $subjectId)
    {
        foreach ($list->subjects() as $subjectEnrolled) {
            if ($subjectEnrolled->subjectId() === $subjectId) {
                return true;
            }
        }
        return false;
    }

}