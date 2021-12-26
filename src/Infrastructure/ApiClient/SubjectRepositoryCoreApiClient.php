<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\ApiClient;

use Cesc\CMRad\Application\Subject\SubjectPlainObject;
use Cesc\CMRad\Domain\CustomerRepository\CustomerRepositoryId;
use Cesc\CMRad\Domain\CustomerRepository\Exception\InvalidCustomerRepositoryIdException;
use Cesc\CMRad\Domain\Subject\Exception\InvalidSubjectIdException;
use Cesc\CMRad\Domain\Subject\Subject;
use Cesc\CMRad\Domain\Subject\SubjectId;
use Cesc\CMRad\Domain\Subject\SubjectRepositoryInterface;

class SubjectRepositoryCoreApiClient extends CoreServiceApiClient implements SubjectRepositoryInterface
{

    public const GET_SUBJECT = self::BASE_ENDPOINT . '/subjects/%s';
    public const POST_SUBJECT = self::BASE_ENDPOINT . '/subjects';

    /**
     * @param SubjectId $subjectId
     * @param CustomerRepositoryId $customerRepositoryId
     * @return Subject|null
     * @throws CoreServiceException
     * @throws InvalidCustomerRepositoryIdException
     * @throws InvalidSubjectIdException
     */
    public function get(SubjectId $subjectId, CustomerRepositoryId $customerRepositoryId): ?Subject
    {
        $coreServiceSubject = $this->request(
            'GET',
            sprintf($this->baseUrl . self::GET_SUBJECT, $customerRepositoryId->value, $subjectId->value)
        );

        return $coreServiceSubject ? new Subject(
            new SubjectId($coreServiceSubject['id']),
            new CustomerRepositoryId($coreServiceSubject['customer_repository_id'])
        ) : null;
    }

    /**
     * @param Subject $subject
     * @return void
     * @throws CoreServiceException
     */
    public function save(Subject $subject): void
    {
        $this->request(
            'GET',
            sprintf($this->baseUrl . self::POST_SUBJECT, $subject->customerRepositoryId()->value),
            json_encode(SubjectPlainObject::fromSubject($subject)->toArray())
        );
    }


}