<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Project;

use Cesc\CMRad\Domain\Project\Exception\InvalidProjectIdException;
use Cesc\CMRad\Domain\Project\ProjectId;
use PHPUnit\Framework\TestCase;

class ProjectIdTest extends TestCase
{
    public function testConstruct(): void
    {
        $repositoryId = new ProjectId(ProjectIdMotherObject::DEFAULT_ID);
        self::assertEquals(ProjectIdMotherObject::DEFAULT_ID, $repositoryId->value);
    }

    public function testInvalidValue(): void
    {
        self::expectException(InvalidProjectIdException::class);
        new ProjectId("not a uuid");
    }

}