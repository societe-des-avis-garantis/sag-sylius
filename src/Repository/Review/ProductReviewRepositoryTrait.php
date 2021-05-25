<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Repository\Review;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use Doctrine\ORM\AbstractQuery;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Review\Model\Review;
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

    /**
     * @param ProductReviewInterface[] $reviews
     *
     * @return void
     */
    public function bulkSave(array $reviews): void
    {
        $batchSize = 20;
        $i = 1;

        foreach ($reviews as $review) {
            $review->setId($this->findIdForSagId($review->getSAGId()));

            if (null !== $review->getId()) {
                $this->_em->merge($review);
            } else {
                $this->_em->persist($review);
            }

            if (($i % $batchSize) === 0) {
                $this->_em->flush();
                $this->_em->clear();
            }
        }

        $this->_em->flush();
        $this->_em->clear();
    }

    protected function findIdForSagId(?string $SAGId): ?int
    {
        if (null === $SAGId) {
            return null;
        }

        $id = $this->createQueryBuilder('o')
            ->select('o.id')
            ->andWhere('o.SAGId = :SAGId')
            ->setParameter('SAGId', $SAGId)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_SINGLE_SCALAR)
        ;

        if (null === $id) {
            return null;
        }

        return (int) $id;
    }
}
