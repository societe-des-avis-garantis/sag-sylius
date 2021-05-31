<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKeyInterface;

final class DediSAGContext implements DediSAGContextInterface
{
    /** @var ApiContextInterface */
    private $apiContext;

    /** @var ApiKeyContext */
    private $apiKeyContext;

    /** @var CertificateOfTruthContextInterface */
    private $certificateOfTruthContext;

    public function __construct(
        ApiContextInterface $apiContext,
        ApiKeyContext $apiKeyContext,
        CertificateOfTruthContextInterface $certificateOfTruthContext
    ) {
        $this->apiContext = $apiContext;
        $this->apiKeyContext = $apiKeyContext;
        $this->certificateOfTruthContext = $certificateOfTruthContext;
    }

    public function getApiKey(): ?ApiKeyInterface
    {
        return $this->apiKeyContext->getApiKey();
    }

    public function getCountryCode(): ?string
    {
        $apiKey = $this->getApiKey();

        return null !== $apiKey ? $apiKey->getCountryCode() : null;
    }

    public function getCertificateOfTruthUrl(): ?string
    {
        return $this->certificateOfTruthContext->getCertificateOfTruthUrl();
    }

    public function getApiDomain(): ?string
    {
        $countryCode = $this->getCountryCode();
        if (null === $countryCode) {
            return null;
        }

        return $this->apiContext->getDomain($countryCode);
    }
}
