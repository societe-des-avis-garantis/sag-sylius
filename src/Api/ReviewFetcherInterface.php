<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Api;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use Dedi\SyliusSAGPlugin\Model\Api\FetchReviewsRequest;

interface ReviewFetcherInterface
{
    /**
     * @param FetchReviewsRequest $request
     *
     * @return ProductReviewInterface[] $reviews
     *
     * @throws \Exception
     */
    public function __invoke(
        FetchReviewsRequest $request
    ): array;
}
