<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Api;

use Dedi\SyliusSAGPlugin\Context\ApiContextInterface;
use Dedi\SyliusSAGPlugin\Model\ApiKeyInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CertificateOfTruthUrlFetcher implements CertificateOfTruthUrlFetcherInterface
{
    /** @var HttpClientInterface */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    /** @var ApiContextInterface */
    private $apiContext;

    public function __construct(
        HttpClientInterface $client,
        LoggerInterface $logger,
        ApiContextInterface $apiContext
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->apiContext = $apiContext;
    }

    public function __invoke(ApiKeyInterface $apiKey): ?string
    {
        try {
            $response = $this->client->request('GET', $this->getUrl($apiKey->getCountryCode()), [
                'query' => [
                    'certificateUrl' => 'certificateUrl',
                    'apiKey' => $apiKey->getApiKey(),
                ],
            ]);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(
                sprintf(
                    'Error fetching certificate of truth url: "%s".',
                    $e->getMessage(),
                ), [
                'exception' => $e,
            ]);

            throw $e;
        }

        try {
            $data = $response->toArray();
        } catch (\Exception $e) {
            return null;
        }

        return (string) $data['certificateUrl'];
    }

    private function getUrl(string $countryCode): string
    {
        return sprintf(
            '%s/wp-content/plugins/ag-core/api/getInfos.php',
            $this->apiContext->getDomain($countryCode)
        );
    }
}
