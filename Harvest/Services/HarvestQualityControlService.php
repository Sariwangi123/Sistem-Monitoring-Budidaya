<?php

namespace Harvest\Services;

use Illuminate\Support\Facades\DB;
use Harvest\Repositories\HarvestQualityControlRepository;

final class HarvestQualityControlService extends \MasterData\Services\BaseService
{
    public function __construct(HarvestQualityControlRepository $repository)
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

    public function markPassed(int|string $id): object
    {
        return DB::transaction(fn (): object => parent::update($id, ['qc_status' => 'Passed']));
    }

    public function markRejected(int|string $id, ?string $notes = null): object
    {
        $payload = ['qc_status' => 'Rejected'];

        if ($notes !== null) {
            $payload['qc_notes'] = $notes;
        }

        return DB::transaction(fn (): object => parent::update($id, $payload));
    }
}
