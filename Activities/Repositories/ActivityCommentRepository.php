<?php

namespace Activities\Repositories;

use Activities\Models\ActivityComment;

final class ActivityCommentRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(ActivityComment $model)
    {
        parent::__construct($model);
    }
}