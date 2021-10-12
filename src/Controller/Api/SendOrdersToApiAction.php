<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Controller\Api;

use Dedi\SyliusSAGPlugin\Api\OrderSenderInterface;
use Dedi\SyliusSAGPlugin\Fetcher\OrdersToExportFetcherInterface;
use Dedi\SyliusSAGPlugin\Model\Api\SendOrdersRequest;
use Dedi\SyliusSAGPlugin\Specification\IsRequestTokenValidSpecification;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SendOrdersToApiAction
{
    /** @var IsRequestTokenValidSpecification */
    private $isRequestTokenValidSpecification;

    /** @var OrderSenderInterface */
    private $orderSender;

    /** @var OrdersToExportFetcherInterface */
    private $ordersToExportFetcher;

    public function __construct(
        IsRequestTokenValidSpecification $isRequestTokenValidSpecification,
        OrderSenderInterface $orderSender,
        OrdersToExportFetcherInterface $ordersToExportFetcher
    ) {
        $this->isRequestTokenValidSpecification = $isRequestTokenValidSpecification;
        $this->orderSender = $orderSender;
        $this->ordersToExportFetcher = $ordersToExportFetcher;
    }

    public function __invoke(
        Request $request
    ): Response {
        try {
            $sendOrdersRequest = $this->getDataFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!$this->isRequestTokenValidSpecification->__invoke($sendOrdersRequest)) {
            return new JsonResponse([
                'message' => 'Invalid token.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $orders = $this->ordersToExportFetcher->__invoke(
            $sendOrdersRequest->getFrom(),
            $sendOrdersRequest->getTo()
        );

        if (0 === count($orders)) {
            return new JsonResponse(['message' => 'No order needs to be sent.']);
        }

        try {
            $this->orderSender->__invoke($sendOrdersRequest, $orders);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Error while sending the orders.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['message' => 'Orders sent.']);
    }

    private function getDataFromRequest(Request $request): SendOrdersRequest
    {
        if (
            !$request->request->has('token') ||
            !$request->request->has('lang')
        ) {
            throw new \InvalidArgumentException('Missing "token" and/or "lang".');
        }

        try {
            return new SendOrdersRequest(
                (string) $request->request->get('token'),
                (string) $request->request->get('lang'),
                new \DateTimeImmutable((string) $request->request->get('fromDate')),
                new \DateTimeImmutable((string) $request->request->get('toDate')),
            );
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('"token", "lang", "fromDate", "toDate" query params must be defined and valid.');
        }
    }
}
