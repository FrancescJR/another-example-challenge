<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Project;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\Project\Project;
use Cesc\CMRad\Domain\Project\ProjectId;
use Cesc\CMRad\Tests\Domain\CustomerRepository\CustomerRepositoryIdMotherObject;

final class ProjectMotherObject
{
    public static function create(
        ?ProjectId $projectId = null,
        ?CustomerRepositoryId $customerRepositoryId = null
    ):Project
    {
        return new Project(
            $projectId ?? ProjectIdMotherObject::create(),
            $customerRepositoryId ?? CustomerRepositoryIdMotherObject::create()
        );
    }

}