<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Api;

use Dedi\SyliusSAGPlugin\Context\ApiContextInterface;
use Dedi\SyliusSAGPlugin\Context\ApiKeyContextInterface;
use Dedi\SyliusSAGPlugin\Model\Api\ApiTokenAwareRequestInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class TokenValidator implements TokenValidatorInterface
{
    /** @var HttpClientInterface */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    /** @var ApiKeyContextInterface */
    private $apiKeyContext;

    /** @var ApiContextInterface */
    private $apiContext;

    public function __construct(
        HttpClientInterface $client,
        LoggerInterface $logger,
        ApiKeyContextInterface $apiKeyContext,
        ApiContextInterface $apiContext
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->apiKeyContext = $apiKeyContext;
        $this->apiContext = $apiContext;
    }

    public function __invoke(ApiTokenAwareRequestInterface $request): bool
    {
        $apiKey = $this->apiKeyContext->findApiKeyByCountryCode($request->getCountryCode());
        if (null === $apiKey) {
            return false;
        }

        $url = $this->apiContext->getUrl(ApiContextInterface::ENDPOINT_CODE_CHECK_TOKEN, $apiKey->getCountryCode());
        $options = [
            'query' => [
                'token' => $request->getToken(),
                'apiKey' => $apiKey->getApiKey(),
            ],
            'timeout' => 30,
        ];

        try {
            $response = $this->client->request(
                'GET',
                $url,
                $options
            );
        } catch (\Exception $e) {
            $this->logger->error(sprintf(
                'Error while validating token "%s" for country code "%s": "%s"',
                $request->getToken(),
                $request->getCountryCode(),
                $e->getMessage(),
            ), [
                'exception' => $e,
                'url' => $url,
                'options' => $options,
            ]);

            return false;
        }

        $data = $response->getContent(false);

        if ('ValidSagData' !== $data) {
            $this->logger->error('Error: invalid token.', [
                'url' => $url,
                'options' => $options,
                'responseContent' => $data,
            ]);

            return false;
        }

        return true;
    }
}
