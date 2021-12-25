<?php

declare(strict_types=1);

namespace Cesc\CMRad\Application\Subject;

use Cesc\CMRad\Domain\Subject\Subject;

class SubjectPlainObject
{
    private function __construct(
        public readonly string $id,
        public readonly string $customerRepositoryId
    ) {

    }

    public static function fromSubject(Subject $subject):self
    {
        return new self(
            $subject->id()->value,
            $subject->customerRepositoryId()->value
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'customer_repository_id' => $this->customerRepositoryId
        ];
    }

}