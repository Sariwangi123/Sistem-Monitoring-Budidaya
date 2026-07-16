<?php

namespace Modules\Administration\Engines;

final class IntegrationEngine
{
    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['adapter_pattern' => true, 'external_integrations_enabled' => false, 'adapters' => ['smtp', 'rest_api', 'webhook', 'oauth_provider', 'whatsapp_future', 'telegram_future']];
    }
}
