<?php

declare(strict_types=1);

namespace Cesc\Prima\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class PrimaController
{
    #[Route('/prima/{uuid}', methods: ['GET'])]
    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        try {
            return new JsonResponse([
                "prima" => $uuid
            ]);
        } catch (Exception $exception) {
            return new JsonResponse(
                ['error' => $exception->getMessage() . $exception::class],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}