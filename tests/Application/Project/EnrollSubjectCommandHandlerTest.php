<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Application\Project;

use Cesc\CMRad\Application\Project\EnrollSubjectCommand;
use Cesc\CMRad\Application\Project\EnrollSubjectCommandHandler;
use Cesc\CMRad\Application\Project\ProjectNotFoundException;
use Cesc\CMRad\Application\Project\SubjectNotFoundException;
use Cesc\CMRad\Application\Subject\CreateSubjectCommandHandler;
use Cesc\CMRad\Domain\Project\Project;
use Cesc\CMRad\Domain\Project\ProjectRepositoryInterface;
use Cesc\CMRad\Domain\Project\SubjectEnrolled\SubjectType;
use Cesc\CMRad\Domain\Subject\Subject;
use Cesc\CMRad\Domain\Subject\SubjectRepositoryInterface;
use Cesc\CMRad\Tests\Domain\Project\ProjectMotherObject;
use Cesc\CMRad\Tests\Domain\Subject\SubjectMotherObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

class EnrollSubjectCommandHandlerTest extends TestCase
{
    private Prophet $prophet;
    private ObjectProphecy $subjectRepositoryProphecy;
    private ObjectProphecy $projectRepositoryProphecy;
    private EnrollSubjectCommandHandler $handler;

    protected function setUp(): void
    {
        $this->prophet = new Prophet();
        $this->subjectRepositoryProphecy = $this->prophet->prophesize(SubjectRepositoryInterface::class);
        $subjectRepository = $this->subjectRepositoryProphecy->reveal();
        /**@var $subjectRepository SubjectRepositoryInterface */
        $this->projectRepositoryProphecy = $this->prophet->prophesize(ProjectRepositoryInterface::class);
        $projectRepository = $this->projectRepositoryProphecy->reveal();
        /**@var $projectRepository ProjectRepositoryInterface */
        $this->handler = new EnrollSubjectCommandHandler(
            $projectRepository,
            $subjectRepository
        );
    }

    public function tearDown():void
    {
        $this->prophet->checkPredictions();
    }

    public function testItEnrolls():void
    {
        //given
        $project = ProjectMotherObject::create();
        $subject = SubjectMotherObject::create();

        $command = new EnrollSubjectCommand(
            $project->id()->value,
            $project->id()->value,
            $subject->id()->value,
            SubjectType::RECIPIENT->value
        );
        $project = $this->prophet->prophesize(Project::class);

        // when
        $this->projectAndSubjectFoundInRepos($project, $subject);

        // then
        $this->projectRepositoryProphecy->save($project)->shouldBeCalled();
        $project->enrollSubject($subject->id(), SubjectType::RECIPIENT)->shouldBeCalled();

        ($this->handler)($command);
        $this->assertTrue(true);
    }

    public function testItThrowsProjectNotFoundException(): void
    {
        //given
        $project = ProjectMotherObject::create();
        $subject = SubjectMotherObject::create();

        $command = new EnrollSubjectCommand(
            $project->id()->value,
            $project->id()->value,
            $subject->id()->value,
            SubjectType::RECIPIENT->value
        );

        // when project not found
        $this->projectRepositoryProphecy->get(Argument::any(), Argument::any())->willReturn(null);
        $this->subjectRepositoryProphecy->get(Argument::any(), Argument::any())->willReturn($subject);

        //then
        $this->expectException(ProjectNotFoundException::class);
        ($this->handler)($command);
    }

    public function testItThrowsSubjectNotFoundException(): void
    {
        //given
        $project = ProjectMotherObject::create();
        $subject = SubjectMotherObject::create();

        $command = new EnrollSubjectCommand(
            $project->id()->value,
            $project->id()->value,
            $subject->id()->value,
            SubjectType::RECIPIENT->value
        );

        // when subject not found
        $this->projectRepositoryProphecy->get(Argument::any(), Argument::any())->willReturn($project);
        $this->subjectRepositoryProphecy->get(Argument::any(), Argument::any())->willReturn(null);

        //then
        $this->expectException(SubjectNotFoundException::class);
        ($this->handler)($command);
    }

    private function projectAndSubjectFoundInRepos(ObjectProphecy $project, Subject $subject):void
    {
        $this->subjectRepositoryProphecy->get(Argument::any(), Argument::any())->willReturn($subject);
        $this->projectRepositoryProphecy->get(Argument::any(), Argument::any())->willReturn($project);
    }

}