<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\CertificateOfTruth;

interface CertificateOfTruthContextInterface
{
    public function getCertificateOfTruth(): ?CertificateOfTruth;
}
