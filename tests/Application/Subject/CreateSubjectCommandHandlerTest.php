<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Application\Subject;

use Cesc\CMRad\Application\Subject\CreateSubjectCommand;
use Cesc\CMRad\Application\Subject\CreateSubjectCommandHandler;
use Cesc\CMRad\Application\Subject\SubjectAlreadyExistsException;
use Cesc\CMRad\Domain\Subject\Subject;
use Cesc\CMRad\Domain\Subject\SubjectRepositoryInterface;
use Cesc\CMRad\Tests\Domain\Subject\SubjectMotherObject;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

class CreateSubjectCommandHandlerTest extends TestCase
{
    private Prophet $prophet;
    private ObjectProphecy $subjectRepositoryProphecy;
    private CreateSubjectCommandHandler $handler;

    protected function setUp(): void
    {
        $this->prophet = new Prophet();
        $this->subjectRepositoryProphecy = $this->prophet->prophesize(SubjectRepositoryInterface::class);
        $subjectRepository = $this->subjectRepositoryProphecy->reveal();
        /**@var $subjectRepository SubjectRepositoryInterface */
        $this->handler = new CreateSubjectCommandHandler($subjectRepository);
    }

    public function tearDown():void
    {
        $this->prophet->checkPredictions();
    }

    public function testItShouldCreateASubject(): void
    {
        //Given
        $subjectToCreate = SubjectMotherObject::create();

        //when
        $this->subjectNotFound($subjectToCreate);

        //then
        $this->subjectRepositoryProphecy->save($subjectToCreate)->shouldBeCalled();

        ($this->handler)(
            new CreateSubjectCommand(
                $subjectToCreate->id()->value,
                $subjectToCreate->customerRepositoryId()->value
            )
        );

        $this->assertTrue(true);
    }

    public function testItShouldNotCreateAnExistingOfferParent(): void
    {
        //Given
        $subjectToCreate = SubjectMotherObject::create();
        // When
        $this->subjectFoundInRepo($subjectToCreate);
        //then
        $this->expectException(SubjectAlreadyExistsException::class);

        ($this->handler)(
            new CreateSubjectCommand(
                $subjectToCreate->id()->value,
                $subjectToCreate->customerRepositoryId()->value
            )
        );
    }

    private function subjectNotFound(Subject $subject): void
    {
        $this->subjectRepositoryProphecy->get($subject->id(), $subject->customerRepositoryId())->willReturn(null);
    }

    private function subjectFoundInRepo(Subject $subject): void
    {
        $this->subjectRepositoryProphecy->get($subject->id(), $subject->customerRepositoryId())->willReturn($subject);
    }



}