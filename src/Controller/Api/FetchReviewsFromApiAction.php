<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Controller\Api;

use Dedi\SyliusSAGPlugin\Api\ReviewFetcherInterface;
use Dedi\SyliusSAGPlugin\Model\Api\FetchReviewsRequest;
use Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FetchReviewsFromApiAction
{
    /** @var ReviewFetcherInterface */
    private $reviewFetcher;

    /** @var ProductReviewRepositoryInterface */
    private $productReviewRepository;

    public function __construct(
        ReviewFetcherInterface $reviewFetcher,
        ProductReviewRepositoryInterface $productReviewRepository
    ) {
        $this->reviewFetcher = $reviewFetcher;
        $this->productReviewRepository = $productReviewRepository;
    }

    public function __invoke(
        Request $request
    ): Response {
        if (
            !$request->query->has('lang')
        ) {
            return new JsonResponse([
                'message' => '"lang" query param must be defined.',
            ], Response::HTTP_BAD_REQUEST);
        }

        $fetchReviewsRequest = new FetchReviewsRequest(
            (string) $request->query->get('lang'),
            array_filter([
                'token' => $request->query->get('token'),
                'productID' => $request->query->get('productID'),
                'idSAG' => $request->query->get('idSAG'),
                'minDate' => $request->query->get('minDate'),
                'maxDate' => $request->query->get('maxDate'),
                'maxR' => $request->query->get('maxR'),
                'from' => $request->query->get('from'),
                'update' => $request->query->get('update'),
            ])
        );

        try {
            $reviews = $this->reviewFetcher->__invoke($fetchReviewsRequest);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Error while fetching the reviews.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (0 === count($reviews)) {
            return new JsonResponse(['message' => 'No review needs to be persisted.']);
        }

        $this->productReviewRepository->bulkSave($reviews);

        return new JsonResponse(['message' => 'Reviews  persisted.']);
    }
}
