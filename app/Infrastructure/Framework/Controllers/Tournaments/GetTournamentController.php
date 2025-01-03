<?php

namespace App\Infrastructure\Framework\Controllers\Tournaments;

use App\Application\Tournaments\UseCases\GetTournamentByIdUseCase;
use App\Infrastructure\Framework\Traits\ResponseFormatter;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class GetTournamentController
{
    use ResponseFormatter;

    public function __construct(private readonly GetTournamentByIdUseCase $getTournamentByIdUseCase){}

    /**
     * Handles the invocation of retrieving tournament data by ID and returning a JSON response.
     *
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $tournament = $this->getTournamentByIdUseCase->execute($id);
            return $this->success($tournament);
        } catch (ModelNotFoundException $e) {
            return $this->error('Tournament not found', 404);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
