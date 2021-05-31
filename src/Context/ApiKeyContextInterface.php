<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKeyInterface;

interface ApiKeyContextInterface
{
    public function getApiKey(): ?ApiKeyInterface;

    public function findApiKeyByCountryCode(string $code): ?ApiKeyInterface;
}
