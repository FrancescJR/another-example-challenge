<?php

declare(strict_types=1);

namespace Cesc\CMRad\Domain\Project;

use Cesc\CMRad\Domain\Project\Exception\InvalidProjectIdException;
use Ramsey\Uuid\Uuid;

final class ProjectId
{
    /**
     * @param string $value
     * @throws InvalidProjectIdException
     */
    public function __construct(
        public readonly string $value
    ) {
        if (!Uuid::isValid($value)) {
            throw new InvalidProjectIdException(sprintf('Invalid uuid format for %s', $value));
        }
    }
}