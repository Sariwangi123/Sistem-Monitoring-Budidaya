<?php

namespace Modules\Notifications\Engines;

use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Resolvers\Contracts\RecipientResolverInterface;

final class NotificationEventEngine
{
    public function __construct(
        private NotificationPolicyEngine $policies,
        private RecipientResolverInterface $recipients,
        private DeliveryEngine $delivery
    ) {
    }

    /** @return array<string, mixed> */
    public function process(DomainEventInterface $event): array
    {
        $definition = $this->policies->resolve($event);
        $recipients = $this->recipients->resolve($definition, $event);
        $results = [];

        foreach ($recipients as $recipient) {
            foreach ($definition->channels as $channel) {
                $results[] = $this->delivery
                    ->deliver($definition, $event, $recipient, $channel)
                    ->toArray();
            }
        }

        return [
            'event_name' => $event->eventName(),
            'source_module' => $event->sourceModule(),
            'correlation_id' => $event->correlationId(),
            'notification_type' => $definition->notificationType,
            'recipient_count' => count($recipients),
            'channel_count' => count($definition->channels),
            'policy' => [
                'priority' => $definition->priority,
                'retry' => $definition->retryPolicy->toArray(),
                'external_delivery_enabled' => false,
            ],
            'results' => $results,
        ];
    }
}
