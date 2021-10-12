<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Api;

use Dedi\SyliusSAGPlugin\Model\ApiKeyInterface;

interface CertificateOfTruthUrlFetcherInterface
{
    public function __invoke(
        ApiKeyInterface $apiKey
    ): ?string;
}
