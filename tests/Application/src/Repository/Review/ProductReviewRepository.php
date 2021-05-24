<?php

declare(strict_types=1);

namespace Tests\Dedi\SyliusSAGPlugin\Application\src\Repository\Review;

use Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryInterface as DediSAGProductReviewRepositoryInterface;
use Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryTrait as DediSAGProductReviewRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductReviewRepository as BaseProductReviewRepository;

final class ProductReviewRepository extends BaseProductReviewRepository implements DediSAGProductReviewRepositoryInterface
{
    use DediSAGProductReviewRepositoryTrait;
}
