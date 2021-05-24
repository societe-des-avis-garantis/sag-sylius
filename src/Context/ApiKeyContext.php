<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Dedi\SyliusSAGPlugin\Model\ApiKey;

final class ApiKeyContext implements ApiKeyContextInterface
{
    /** @var ApiKey|null */
    private $apiKey;

    public function __construct(
        string $key
    ) {
        if ('' === $key) {
            $this->apiKey = null;

            return;
        }

        if (false === preg_match('/^(\d+)\/([a-z]{2})\/(.+)$/', $key, $matches)) {
            throw new \LogicException('Api Key does not have the correct format.');
        }

        $this->apiKey = new ApiKey(
            (int) $matches[1],
            $matches[2],
            $matches[3]
        );
    }

    public function getApiKey(): ?ApiKey
    {
        return $this->apiKey;
    }
}
