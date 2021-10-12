<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory\Review;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use Dedi\SyliusSAGPlugin\Model\Api\ReviewDTO;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Review\Model\Reviewer;

trait ReviewFactoryTrait
{
    /** @var FactoryInterface */
    private $reviewerFactory;

    public function __construct(
        FactoryInterface $reviewerFactory
    ) {
        $this->reviewerFactory = $reviewerFactory;
    }

    public function buildFromDTO(ReviewDTO $dto): ProductReviewInterface
    {
        /** @var ProductReviewInterface $review */
        $review = $this->createNew();
        $review->setReviewSubject($dto->reviewSubject);
        $review->setSAGId($dto->SAGId);
        $review->setRating($dto->rating);
        $review->setComment($dto->comment);

        /** @var Reviewer $author */
        $author = $this->reviewerFactory->createNew();
        $author->setFirstName($dto->reviewerFirstName);
        $author->setLastName($dto->reviewerLastName);
        $author->setEmail(sprintf('%s.%s@email', $dto->reviewerFirstName, $dto->reviewerLastName));
        $review->setAuthor($author);

        $review->setCreatedAt($dto->createdAt);
        $review->setStatus($dto->status);
        $review->setSAGAnswerComment($dto->SAGAnswerComment);
        $review->setSAGAnswerCreatedAt($dto->SAGAnswerCreatedAt);
        $review->setSAGCountryCode($dto->countryCode);

        return $review;
    }
}
