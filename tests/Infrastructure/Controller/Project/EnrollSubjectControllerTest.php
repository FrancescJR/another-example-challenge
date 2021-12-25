<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Infrastructure\Controller\Project;

use Cesc\CMRad\Application\Project\EnrollSubjectCommandHandler;
use Cesc\CMRad\Infrastructure\Controller\Project\EnrollSubjectController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EnrollSubjectControllerTest extends TestCase
{
    private EnrollSubjectController $controller;

    public function setUp():void
    {
        $this->controller = new EnrollSubjectController(self::createMock(EnrollSubjectCommandHandler::class));
    }

    public function testItReturnsJsonResponse(): void
    {
        $request = new Request([],[],[],[],[],[], json_encode([
            'subject_id' => 'subject-id',
            'subject_type' => 'subject type'

        ]));
        $response = ($this->controller)($request, 'repo id', 'projectId');
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testItReturnsBadResponseWhenRequestMissesParams():void
    {
        $request = new Request();
        $response = ($this->controller)($request, 'repo id', 'project id');
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

}