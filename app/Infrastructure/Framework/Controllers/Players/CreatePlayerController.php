<?php
declare(strict_types=1);

namespace App\Infrastructure\Framework\Controllers\Players;

use App\Application\Players\UseCases\StorePlayerUseCase;
use App\Infrastructure\Framework\Requests\StorePlayerRequest;
use App\Infrastructure\Framework\Traits\ResponseFormatter;
use Illuminate\Http\JsonResponse;

final readonly class CreatePlayerController
{
    use ResponseFormatter;
    public function __construct(private StorePlayerUseCase $storePlayerAction){}

    public function __invoke(StorePlayerRequest $request): JsonResponse
    {
        $player = $this->storePlayerAction->create($request->all());

        return $this->success($player, 'Player created successfully');
    }
}
