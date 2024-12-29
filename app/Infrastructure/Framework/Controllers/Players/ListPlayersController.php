<?php

namespace App\Infrastructure\Framework\Controllers\Players;

use App\Application\Players\UseCases\GetPlayersUseCase;
use App\Infrastructure\Framework\Traits\ResponseFormatter;
use Illuminate\Http\JsonResponse;

class ListPlayersController
{
    use ResponseFormatter;

    public function __construct(private readonly GetPlayersUseCase $getPlayersUseCase){}

    public function __invoke(): JsonResponse
    {
        $players = $this->getPlayersUseCase->execute();
        return $this->success($players);
    }
}
