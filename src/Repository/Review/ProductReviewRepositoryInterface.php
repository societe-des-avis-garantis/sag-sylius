<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Repository\Review;

use Pagerfanta\Pagerfanta;
use Sylius\Component\Core\Repository\ProductReviewRepositoryInterface as BaseProductReviewRepositoryInterface;

interface ProductReviewRepositoryInterface extends BaseProductReviewRepositoryInterface
{
    public function createQueryBuilderForAcceptedByProductSlugAndCountryCode(
        string $slug,
        string $locale,
        ?string $countryCode
    ): Pagerfanta;
}
