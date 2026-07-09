<?php

namespace MasterData\Repositories;

use MasterData\Models\GeneralReference;

final class GeneralReferenceRepository extends BaseRepository
{
    public function __construct(GeneralReference $model)
    {
        parent::__construct($model);
    }
}