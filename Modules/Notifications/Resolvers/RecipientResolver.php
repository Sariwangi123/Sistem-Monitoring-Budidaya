<?php

namespace Modules\Notifications\Resolvers;

use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Exceptions\InvalidRecipientException;
use Modules\Notifications\Resolvers\Contracts\RecipientResolverInterface;
use Modules\Notifications\Support\NotificationDefinition;
use Modules\Notifications\Support\NotificationRecipient;

final class RecipientResolver implements RecipientResolverInterface
{
    public function resolve(NotificationDefinition $definition, DomainEventInterface $event): array
    {
        $recipients = match (true) {
            str_starts_with($definition->recipientStrategy, 'user:') => $this->userRecipients($definition, $event),
            str_starts_with($definition->recipientStrategy, 'role:') => $this->roleRecipients($definition),
            str_starts_with($definition->recipientStrategy, 'farm:') => $this->payloadRecipient('farm', $event),
            str_starts_with($definition->recipientStrategy, 'department:') => $this->payloadRecipient('department', $event),
            str_starts_with($definition->recipientStrategy, 'company:') => $this->payloadRecipient('company', $event),
            default => [],
        };

        if ($recipients === []) {
            throw InvalidRecipientException::forStrategy($definition->recipientStrategy);
        }

        return $recipients;
    }

    /** @return array<int, NotificationRecipient> */
    private function roleRecipients(NotificationDefinition $definition): array
    {
        $role = str($definition->recipientStrategy)->after('role:')->toString();

        return [new NotificationRecipient('role', $role, str($role)->headline()->toString())];
    }

    /** @return array<int, NotificationRecipient> */
    private function userRecipients(NotificationDefinition $definition, DomainEventInterface $event): array
    {
        $identifier = str($definition->recipientStrategy)->after('user:')->toString();
        $identifier = $identifier === 'payload' ? (string) ($event->payload()['user_id'] ?? '') : $identifier;

        return $identifier === '' ? [] : [new NotificationRecipient('user', $identifier)];
    }

    /** @return array<int, NotificationRecipient> */
    private function payloadRecipient(string $type, DomainEventInterface $event): array
    {
        $identifier = (string) ($event->payload()[$type.'_id'] ?? '');

        return $identifier === '' ? [] : [new NotificationRecipient($type, $identifier)];
    }
}
