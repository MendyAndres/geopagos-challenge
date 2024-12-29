<?php
declare(strict_types=1);

namespace App\Infrastructure\Framework\Controllers\Tournaments;

use App\Application\Players\UseCases\StorePlayerUseCase;
use App\Application\Tournaments\UseCases\ExecuteTournamentUseCase;
use App\Application\Tournaments\UseCases\StoreTournamentUseCase;
use App\Domain\Players\Entities\Player;
use App\Domain\Tournaments\Entities\Tournament;
use App\Infrastructure\Framework\Traits\ResponseFormatter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final readonly class ExecuteTournamentController
{
    use ResponseFormatter;
    public function __construct(
        private ExecuteTournamentUseCase $executeTournamentUseCase,
        private StorePlayerUseCase $storePlayerUseCase,
        private StoreTournamentUseCase $storeTournamentUseCase,
    ){}

    public function __invoke(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try{
            $tournament = $this->storeTournamentUseCase->execute($request->tournament);

            $tournamentEntity = new Tournament(
                $tournament['id'],
                $tournament['name'],
                $tournament['type'],
            );

            $playerEntities = array_map(function($player) use ($tournament) {
                $player['tournament_id'] = $tournament['id'];
                $eloquentPlayer = $this->storePlayerUseCase->create($player);
                return new Player(
                    $eloquentPlayer['id'],
                    $eloquentPlayer['name'],
                    $eloquentPlayer['skill_level'],
                    $eloquentPlayer['gender'],
                    $eloquentPlayer['strength_level'],
                    $eloquentPlayer['speed_level'],
                    $eloquentPlayer['reaction_time'],
                    $eloquentPlayer['tournament_id'],
                );
            }, $request->players);

            $result = $this->executeTournamentUseCase->execute($playerEntities, $tournamentEntity);

            DB::commit();
            return $this->success($result, 'Tournament executed successfully');
        } catch (\InvalidArgumentException $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), 400);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }

    }
}
