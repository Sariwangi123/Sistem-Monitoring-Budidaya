<?php

namespace Modules\Notifications\Channels;

use Modules\Notifications\Channels\Contracts\ChannelAdapterInterface;
use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Support\DeliveryResult;
use Modules\Notifications\Support\NotificationDefinition;
use Modules\Notifications\Support\NotificationRecipient;

final class InAppChannelAdapter implements ChannelAdapterInterface
{
    public function channel(): string
    {
        return 'in_app';
    }

    public function available(): bool
    {
        return true;
    }

    public function deliver(NotificationDefinition $definition, DomainEventInterface $event, NotificationRecipient $recipient): DeliveryResult
    {
        return new DeliveryResult('in_app', 'delivered', [
            'adapter' => self::class,
            'recipient' => $recipient->toArray(),
            'event_name' => $event->eventName(),
            'foundation_only' => true,
        ]);
    }
}
