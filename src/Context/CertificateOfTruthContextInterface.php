<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

interface CertificateOfTruthContextInterface
{
    public function getCertificateOfTruthUrl(): ?string;
}
