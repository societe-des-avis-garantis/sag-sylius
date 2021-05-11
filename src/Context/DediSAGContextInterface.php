<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKey;
use Dedi\SyliusSAGPlugin\Model\CertificateOfTruth;

interface DediSAGContextInterface
{
    public function getApiKey(): ?ApiKey;

    public function getCountryCode(): ?string;

    public function getCertificateOfTruth(): ?CertificateOfTruth;
}
