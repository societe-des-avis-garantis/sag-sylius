<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\CertificateOfTruth;

final class CertificateOfTruthContext implements CertificateOfTruthContextInterface
{
    /** @var CertificateOfTruth|null */
    private $certificateOfTruth;

    public function __construct(
        string $certificateOfTruthLink
    ) {
        if ('' === $certificateOfTruthLink) {
            $this->certificateOfTruth = null;

            return;
        }

        $this->certificateOfTruth = new CertificateOfTruth($certificateOfTruthLink);
    }

    public function getCertificateOfTruth(): ?CertificateOfTruth
    {
        return $this->certificateOfTruth;
    }
}
