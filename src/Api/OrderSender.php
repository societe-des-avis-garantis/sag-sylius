<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Api;

use Dedi\SyliusSAGPlugin\Context\ApiContextInterface;
use Dedi\SyliusSAGPlugin\Context\ApiKeyContextInterface;
use Dedi\SyliusSAGPlugin\Factory\Order\OrderExportDataFactoryInterface;
use Dedi\SyliusSAGPlugin\Model\Api\ApiTokenAwareRequestInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OrderSender implements OrderSenderInterface
{
    /** @var HttpClientInterface */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    /** @var OrderExportDataFactoryInterface */
    private $orderExportDataFactory;

    /** @var ApiKeyContextInterface */
    private $apiKeyContext;

    /** @var ApiContextInterface */
    private $apiContext;

    public function __construct(
        HttpClientInterface $client,
        LoggerInterface $logger,
        OrderExportDataFactoryInterface $orderExportDataFactory,
        ApiKeyContextInterface $apiKeyContext,
        ApiContextInterface $apiContext
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->orderExportDataFactory = $orderExportDataFactory;
        $this->apiKeyContext = $apiKeyContext;
        $this->apiContext = $apiContext;
    }

    public function __invoke(
        ApiTokenAwareRequestInterface $request,
        array $orders
    ): void {
        $data = $this->orderExportDataFactory->__invoke($orders);

        $apiKey = $this->apiKeyContext->findApiKeyByCountryCode($request->getCountryCode());
        if (null === $apiKey) {
            $message = sprintf(
                'ApiKey not found for country code: "%s".',
                $request->getCountryCode(),
            );

            $this->logger->error($message, [
                'request' => $request,
            ]);

            throw new \LogicException($message);
        }

        try {
            $encoded = json_encode($data);
            if (false === $encoded) {
                throw new \LogicException('Could not encode data.');
            }

            $url = $this->apiContext->getUrl(ApiContextInterface::ENDPOINT_CODE_ORDER_EXPORT, $apiKey->getCountryCode());
            $response = $this->client->request('POST', $url, [
                'query' => [
                    'token' => $request->getToken(),
                    'apiKey' => $apiKey->getApiKey(),
                ],
                'body' => [
                    'data' => base64_encode($encoded),
                ],
            ]);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(
                sprintf(
                    'Error while sending orders: "%s".',
                    $e->getMessage(),
                ), [
                'exception' => $e,
                'request' => $request,
                'data' => $data,
            ]);

            throw $e;
        }

        $this->logger->info(sprintf(
            'Order sent response message: "%s"',
            $response->getContent(false),
        ));
    }
}
