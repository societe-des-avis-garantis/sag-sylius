<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

final class CertificateOfTruthContext implements CertificateOfTruthContextInterface
{
    /** @var ApiKeyContextInterface */
    private $apiKeyContext;

    public function __construct(
        ApiKeyContextInterface $apiKeyContext
    ) {
        $this->apiKeyContext = $apiKeyContext;
    }

    public function getCertificateOfTruthUrl(): ?string
    {
        $apiKeyConfig = $this->apiKeyContext->getApiKey();
        if (null === $apiKeyConfig) {
            return null;
        }

        return $apiKeyConfig->getCertificateOfTruthUrl();
    }
}
