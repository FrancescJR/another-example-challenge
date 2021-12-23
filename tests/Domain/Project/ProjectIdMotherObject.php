<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Project;

use Cesc\CMRad\Domain\Project\Exception\InvalidProjectIdException;
use Cesc\CMRad\Domain\Project\ProjectId;
use Faker\Factory;

final class ProjectIdMotherObject
{
    public const DEFAULT_ID = "8b53e1a8-71e3-3334-93fc-0098227fee71";

    /**
     * @param string|null $value
     * @return ProjectId
     * @throws InvalidProjectIdException
     */
    public static function create(?string $value = null): ProjectId
    {
        return new ProjectId($value ?? Factory::create()->uuid);
    }

}