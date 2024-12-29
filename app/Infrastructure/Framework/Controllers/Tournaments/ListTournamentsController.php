<?php

namespace App\Infrastructure\Framework\Controllers\Tournaments;

use App\Application\Tournaments\UseCases\GetTournamentsUseCase;
use App\Infrastructure\Framework\Requests\ListTournamentsRequest;
use App\Infrastructure\Framework\Traits\ResponseFormatter;
use Exception;
use Illuminate\Http\JsonResponse;

class ListTournamentsController
{
    use ResponseFormatter;
    public function __construct(private readonly GetTournamentsUseCase $getTournamentsUseCase){}

    public function __invoke(ListTournamentsRequest $request): JsonResponse
    {
        try {
            $filters = $request->only(['gender', 'from_date', 'to_date']);
            $tournaments = $this->getTournamentsUseCase->execute($filters);
            return $this->success($tournaments);
        }catch (Exception $e){
            return $this->error($e->getMessage());
        }

    }
}
