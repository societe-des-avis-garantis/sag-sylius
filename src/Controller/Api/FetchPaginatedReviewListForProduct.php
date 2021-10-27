<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Controller\Api;

use Dedi\SyliusSAGPlugin\Context\DediSAGContextInterface;
use Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class FetchPaginatedReviewListForProduct extends AbstractController
{
    public const LIMIT_PER_PAGE = 50;

    /** @var ProductReviewRepositoryInterface */
    private $productReviewRepository;

    /** @var DediSAGContextInterface */
    private $dediSAGContext;

    /** @var LocaleContextInterface */
    private $localeContext;

    public function __construct(
        ProductReviewRepositoryInterface $productReviewRepository,
        DediSAGContextInterface $dediSAGContext,
        LocaleContextInterface $localeContext
    ) {
        $this->productReviewRepository = $productReviewRepository;
        $this->dediSAGContext = $dediSAGContext;
        $this->localeContext = $localeContext;
    }

    public function __invoke(
        string $productSlug,
        int $currentPage,
        int $maxPerPage
    ): Response {
        $countryCode = $this->dediSAGContext->getCountryCode();
        if ($countryCode === null) {
            return new Response();
        }

        $pager = $this->productReviewRepository->createQueryBuilderForAcceptedByProductSlugAndCountryCode(
            $productSlug,
            $this->localeContext->getLocaleCode(),
            $countryCode
        );

        $pager->setCurrentPage($currentPage)
            ->setMaxPerPage($maxPerPage < self::LIMIT_PER_PAGE ? $maxPerPage : self::LIMIT_PER_PAGE)
        ;

        return $this->render('@DediSyliusSAGPlugin/Shop/ProductReview/list.html.twig', [
            'product_reviews' => $pager,
        ]);
    }
}
