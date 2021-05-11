<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Repository\Review;

use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Review\Model\ReviewInterface;

trait ProductReviewRepositoryTrait
{
    public function createQueryBuilderForAcceptedByProductSlugAndCountryCode(
        string $slug,
        string $locale,
        ?string $countryCode
    ): PagerFanta {
        $queryBuilder = $this->createQueryBuilder('o')
            ->innerJoin('o.reviewSubject', 'product')
            ->innerJoin('product.translations', 'translation')
            ->andWhere('translation.locale = :locale')
            ->andWhere('translation.slug = :slug')
            ->andWhere('o.status = :status')
            ->andWhere('o.SAGCountryCode = :countryCode')
            ->setParameter('locale', $locale)
            ->setParameter('slug', $slug)
            ->setParameter('status', ReviewInterface::STATUS_ACCEPTED)
            ->setParameter('countryCode', $countryCode)
            ->orderBy('o.createdAt', 'DESC')
        ;

        $adapter = new QueryAdapter($queryBuilder, false);

        return new Pagerfanta($adapter);
    }

    public function findLatestByProductIdAndCountryCode(
        $productId,
        int $count,
        ?string $countryCode
    ): array {
        return $this->createQueryBuilder('o')
            ->andWhere('o.reviewSubject = :productId')
            ->andWhere('o.status = :status')
            ->andWhere('o.SAGCountryCode = :countryCode')
            ->setParameter('productId', $productId)
            ->setParameter('status', ReviewInterface::STATUS_ACCEPTED)
            ->setParameter('countryCode', $countryCode)
            ->addOrderBy('o.createdAt', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
        ;
    }
}
