<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\Controller\Subject;

use Cesc\CMRad\Application\Subject\CreateSubjectCommand;
use Cesc\CMRad\Application\Subject\CreateSubjectCommandHandler;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
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
            $requestContent = $this->validateRequestAndGetContent($request);
            ($this->createSubjectCommandHandler)(
                new CreateSubjectCommand(
                    (string)$requestContent['id'],
                    $repositoryId
                )
            );
        } catch (Exception) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse([], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function validateRequestAndGetContent(Request $request): array
    {
        $requestContent = json_decode($request->getContent(), true);
        if (!$requestContent or !array_key_exists('id', $requestContent)) {
            throw new BadRequestException("Missing subject id");
        }
        return $requestContent;
    }

}