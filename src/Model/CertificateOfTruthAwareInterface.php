<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model;

interface CertificateOfTruthAwareInterface
{
    public function getCertificateOfTruthUrl(): ?string;
}
