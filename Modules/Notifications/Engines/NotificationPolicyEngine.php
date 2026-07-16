<?php

namespace Modules\Notifications\Engines;

use Modules\Notifications\Channels\Contracts\ChannelResolverInterface;
use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Exceptions\NotificationPolicyException;
use Modules\Notifications\Registry\NotificationRegistry;
use Modules\Notifications\Support\NotificationDefinition;

final class NotificationPolicyEngine
{
    public function __construct(
        private NotificationRegistry $registry,
        private ChannelResolverInterface $channels
    ) {
    }

    public function resolve(DomainEventInterface $event): NotificationDefinition
    {
        $definition = $this->registry->get($event->eventName());

        if ($definition->channels === []) {
            throw NotificationPolicyException::forEvent($event->eventName(), 'at least one channel is required');
        }

        foreach ($definition->channels as $channel) {
            $this->channels->resolve($channel);
        }

        return $definition;
    }
}
