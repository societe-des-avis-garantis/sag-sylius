<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKey;

interface ApiKeyContextInterface
{
    public function getApiKey(): ?ApiKey;

    public function findApiKeyByCountryCode(string $code): ?ApiKey;
}
