<?php

namespace Harvest\Services;

use Illuminate\Support\Facades\DB;
use Harvest\Repositories\HarvestGradeRepository;

final class HarvestGradeService extends \MasterData\Services\BaseService
{
    public function __construct(HarvestGradeRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function accept(int|string $id): object
    {
        return DB::transaction(fn (): object => parent::update($id, ['quality_status' => 'Accepted']));
    }

    public function hold(int|string $id, ?string $notes = null): object
    {
        $payload = ['quality_status' => 'Hold'];

        if ($notes !== null) {
            $payload['notes'] = $notes;
        }

        return DB::transaction(fn (): object => parent::update($id, $payload));
    }
}
