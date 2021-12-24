<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\Controller\Subject;

use Cesc\CMRad\Application\Subject\CreateSubjectCommand;
use Cesc\CMRad\Application\Subject\CreateSubjectCommandHandler;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateSubjectController
{
    public function __construct(
        private CreateSubjectCommandHandler $createSubjectCommandHandler
    ) {
    }

    #[Route('/subjects/repository/{repositoryId}/subject', methods: ['POST'])]
    public function __invoke(Request $request, string $repositoryId): JsonResponse
    {
        try {
            ($this->createSubjectCommandHandler)(
                new CreateSubjectCommand(
                    $request->get("id"),
                    $repositoryId
                )
            );
        } catch (Exception) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse();
    }

}