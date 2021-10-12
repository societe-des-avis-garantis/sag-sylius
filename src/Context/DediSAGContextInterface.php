<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKeyInterface;

interface DediSAGContextInterface
{
    public function getApiKey(): ?ApiKeyInterface;

    public function getCountryCode(): ?string;

    public function getCertificateOfTruthUrl(): ?string;
}
