<?php

namespace Activities\Repositories;

use Activities\Models\ActivityAttachment;

final class ActivityAttachmentRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(ActivityAttachment $model)
    {
        parent::__construct($model);
    }
}