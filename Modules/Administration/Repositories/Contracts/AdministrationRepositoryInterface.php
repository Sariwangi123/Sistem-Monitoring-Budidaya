<?php

namespace Modules\Administration\Repositories\Contracts;

interface AdministrationRepositoryInterface
{
    /** @return array<string, int> */
    public function platformSummary(): array;

    /** @return array<int, array<string, string>> */
    public function supportedRoles(): array;
}
