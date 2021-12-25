<?php

declare(strict_types=1);

namespace Cesc\CMRad\Infrastructure\Controller\Project;

use Cesc\CMRad\Application\Project\EnrollSubjectCommand;
use Cesc\CMRad\Application\Project\EnrollSubjectCommandHandler;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EnrollSubjectController
{
    public function __construct(
        private EnrollSubjectCommandHandler $enrollSubjectCommandHandler
    ) {
    }

    #[Route('/project/{projectId}', methods: ['PUT'])]
    public function __invoke(Request $request, string $repositoryId, string $projectId): JsonResponse
    {
        try {
            $requestContent = $this->validateRequestAndGetContent($request);
            ($this->enrollSubjectCommandHandler)(
                new EnrollSubjectCommand(
                    $projectId,
                    $repositoryId,
                    $requestContent['subject_id'],
                    $requestContent['subject_type'],
                )
            );
        } catch (Exception $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @return array
     */
    private function validateRequestAndGetContent(Request $request): array
    {
        $requestContent = json_decode($request->getContent(), true);
        if (!$requestContent or !array_key_exists('subject_id', $requestContent)) {
            throw new BadRequestException("Missing subject_id");
        }
        if (!array_key_exists('subject_type', $requestContent)) {
            throw new BadRequestException("Missing subject_type");
        }
        return $requestContent;
    }

}