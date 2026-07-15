<?php

namespace Harvest\Repositories;

use Harvest\Models\HarvestDelivery;
use Harvest\Repositories\Contracts\HarvestDeliveryRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class HarvestDeliveryRepository extends BaseRepository implements HarvestDeliveryRepositoryInterface
{
    public function __construct(HarvestDelivery $model)
    {
        parent::__construct($model);
    }
}
