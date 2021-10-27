<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;

interface ApiKeyContextInterface
{
    public function getApiKey(): ?ApiKeyConfigInterface;

    public function findApiKeyByCountryCode(string $code): ?ApiKeyConfigInterface;
}
