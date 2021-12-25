<?php

declare(strict_types=1);

namespace Cesc\CMRad\Tests\Infrastructure\Controller\Subject;

use Cesc\CMRad\Application\Subject\CreateSubjectCommandHandler;
use Cesc\CMRad\Infrastructure\Controller\Subject\CreateSubjectController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CreateSubjectControllerTest extends TestCase
{
    private CreateSubjectController $controller;

    public function setUp():void
    {
        $this->controller = new CreateSubjectController(self::createMock(CreateSubjectCommandHandler::class));
    }

    public function testItReturnsJsonResponse(): void
    {
        $request = new Request([],[],[],[],[],[],
        json_encode(['id' => 'subject-id']));
        $response = ($this->controller)($request, "repoId");
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testItReturnsBadResponseWhenRequestMissesParams():void
    {
        $request = new Request();
        $response = ($this->controller)($request, "repoId");
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

}