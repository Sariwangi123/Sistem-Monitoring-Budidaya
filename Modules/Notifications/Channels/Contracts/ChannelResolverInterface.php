<?php

namespace Modules\Notifications\Channels\Contracts;

interface ChannelResolverInterface
{
    public function resolve(string $channel): ChannelAdapterInterface;

    /** @return array<int, array<string, mixed>> */
    public function supportedChannels(): array;
}
