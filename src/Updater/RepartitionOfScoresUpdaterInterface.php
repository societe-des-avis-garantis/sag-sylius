<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Updater;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;

interface RepartitionOfScoresUpdaterInterface
{
    /**
     * @param ProductReviewInterface[] $reviews
     */
    public function __invoke(
        array $reviews,
        string $countryCode
    ): void;
}
