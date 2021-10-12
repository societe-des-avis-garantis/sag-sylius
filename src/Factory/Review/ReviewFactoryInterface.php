<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory\Review;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use Dedi\SyliusSAGPlugin\Model\Api\ReviewDTO;
use Sylius\Component\Review\Factory\ReviewFactoryInterface as BaseReviewFactoryInterface;

interface ReviewFactoryInterface extends BaseReviewFactoryInterface
{
    public function buildFromDTO(ReviewDTO $dto): ProductReviewInterface;
}
