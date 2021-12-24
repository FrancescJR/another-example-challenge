<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Subject;

use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\Subject\Subject;
use Cesc\CMRad\Domain\Subject\SubjectId;
use Cesc\CMRad\Tests\Domain\CustomerRepository\CustomerRepositoryIdMotherObject;

class SubjectMotherObject
{
    public static function create(
        ?SubjectId $subjectId = null,
        ?CustomerRepositoryId $customerRepositoryId = null
    ):Subject
    {
        return new Subject(
            $subjectId ?? SubjectIdMotherObject::create(),
            $customerRepositoryId ?? CustomerRepositoryIdMotherObject::create()
        );
    }

}