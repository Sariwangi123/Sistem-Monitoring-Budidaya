<?php

namespace Modules\Notifications\Channels\Contracts;

use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Support\DeliveryResult;
use Modules\Notifications\Support\NotificationDefinition;
use Modules\Notifications\Support\NotificationRecipient;

interface ChannelAdapterInterface
{
    public function channel(): string;

    public function available(): bool;

    public function deliver(NotificationDefinition $definition, DomainEventInterface $event, NotificationRecipient $recipient): DeliveryResult;
}
