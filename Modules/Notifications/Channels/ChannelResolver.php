<?php

namespace Modules\Notifications\Channels;

use Modules\Notifications\Channels\Contracts\ChannelAdapterInterface;
use Modules\Notifications\Channels\Contracts\ChannelResolverInterface;
use Modules\Notifications\Exceptions\ChannelUnavailableException;

final class ChannelResolver implements ChannelResolverInterface
{
    /** @var array<string, ChannelAdapterInterface> */
    private array $adapters;

    public function __construct(InAppChannelAdapter $inApp)
    {
        $this->adapters = [
            $inApp->channel() => $inApp,
        ];
    }

    public function resolve(string $channel): ChannelAdapterInterface
    {
        $adapter = $this->adapters[$channel] ?? null;

        if (! $adapter || ! $adapter->available()) {
            throw ChannelUnavailableException::forChannel($channel);
        }

        return $adapter;
    }

    public function supportedChannels(): array
    {
        return [
            ['key' => 'in_app', 'available' => true, 'external' => false],
            ['key' => 'email', 'available' => false, 'external' => true],
            ['key' => 'whatsapp', 'available' => false, 'external' => true],
            ['key' => 'telegram', 'available' => false, 'external' => true],
            ['key' => 'push_notification', 'available' => false, 'external' => true],
            ['key' => 'sms', 'available' => false, 'external' => true],
        ];
    }
}
