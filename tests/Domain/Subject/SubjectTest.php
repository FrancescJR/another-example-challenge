<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Domain\Subject;

use Cesc\CMRad\Domain\Subject\Subject;
use Cesc\CMRad\Tests\Domain\CustomerRepository\CustomerRepositoryIdMotherObject;
use PHPUnit\Framework\TestCase;

class SubjectTest extends TestCase
{
    public function testConstruct(): void
    {
        $subjectId = SubjectIdMotherObject::create();
        $customerRepositoryId = CustomerRepositoryIdMotherObject::create();
        $subject = new Subject(
            $subjectId,
            $customerRepositoryId
        );

        self::assertEquals($subjectId, $subject->id());
        self::assertEquals($customerRepositoryId, $subject->customerRepositoryId());
    }



}