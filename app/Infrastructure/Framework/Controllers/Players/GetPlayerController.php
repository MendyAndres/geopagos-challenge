<?php
declare(strict_types=1);

namespace App\Infrastructure\Framework\Controllers\Players;

use App\Application\Players\UseCases\GetPlayerByIdUseCase;
use App\Infrastructure\Framework\Traits\ResponseFormatter;
use Illuminate\Http\JsonResponse;

final readonly class GetPlayerController
{
    use ResponseFormatter;
    public function __construct(private GetPlayerByIdUseCase $getPlayerAction){}

    public function __invoke(int $id): JsonResponse
    {
        $player = $this->getPlayerAction->execute($id);

        return $this->success($player, 'Player retrieved successfully');
    }
}
