<?php

namespace Modules\Notifications\Resolvers\Contracts;

use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Support\NotificationDefinition;

interface RecipientResolverInterface
{
    /** @return array<int, \Modules\Notifications\Support\NotificationRecipient> */
    public function resolve(NotificationDefinition $definition, DomainEventInterface $event): array;
}
