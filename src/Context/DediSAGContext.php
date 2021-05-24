<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKey;
use Dedi\SyliusSAGPlugin\Model\CertificateOfTruth;

final class DediSAGContext implements DediSAGContextInterface
{
    /** @var ApiKeyContext */
    private $apiKeyContext;

    /** @var CertificateOfTruthContextInterface */
    private $certificateOfTruthContext;

    public function __construct(
        ApiKeyContext $apiKeyContext,
        CertificateOfTruthContextInterface $certificateOfTruthContext
    ) {
        $this->apiKeyContext = $apiKeyContext;
        $this->certificateOfTruthContext = $certificateOfTruthContext;
    }

    public function getApiKey(): ?ApiKey
    {
        return $this->apiKeyContext->getApiKey();
    }

    public function getCountryCode(): ?string
    {
        $apiKey = $this->getApiKey();

        return null !== $apiKey ? $apiKey->getCountryCode() : null;
    }

    public function getCertificateOfTruth(): ?CertificateOfTruth
    {
        return $this->certificateOfTruthContext->getCertificateOfTruth();
    }
}
