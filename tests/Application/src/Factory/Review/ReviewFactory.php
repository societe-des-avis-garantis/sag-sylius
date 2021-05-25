<?php

declare(strict_types=1);

namespace Tests\Dedi\SyliusSAGPlugin\Application\src\Factory\Review;

use Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryInterface as DediSAGReviewFactoryInterface;
use Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryTrait as DediSAGReviewFactoryTrait;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Review\Factory\ReviewFactoryInterface;
use Sylius\Component\Review\Model\ReviewableInterface;
use Sylius\Component\Review\Model\ReviewerInterface;
use Sylius\Component\Review\Model\ReviewInterface;

final class ReviewFactory implements DediSAGReviewFactoryInterface
{
    use DediSAGReviewFactoryTrait {
        __construct as initializeDediSAGArguments;
    }

    /** @var ReviewFactoryInterface */
    private $baseFactory;

    public function __construct(
        ReviewFactoryInterface $baseFactory,
        FactoryInterface $reviewerFactory
    ) {
        $this->baseFactory = $baseFactory;

        $this->initializeDediSAGArguments($reviewerFactory);
    }

    public function createNew()
    {
        return $this->baseFactory->createNew();
    }

    public function createForSubject(ReviewableInterface $subject): ReviewInterface
    {
        return $this->baseFactory->createForSubject($subject);
    }

    public function createForSubjectWithReviewer(ReviewableInterface $subject, ?ReviewerInterface $reviewer): ReviewInterface
    {
        return $this->baseFactory->createForSubjectWithReviewer($subject, $reviewer);
    }
}
