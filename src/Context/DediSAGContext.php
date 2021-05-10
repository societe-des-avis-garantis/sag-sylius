<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKey;

class DediSAGContext implements DediSAGContextInterface
{
    /** @var ApiKeyContext */
    private $apiKeyContext;

    public function __construct(
        ApiKeyContext $apiKeyContext
    ) {
        $this->apiKeyContext = $apiKeyContext;
    }

    public function getApiKey(): ?ApiKey
    {
        return $this->apiKeyContext->getApiKey();
    }
}
