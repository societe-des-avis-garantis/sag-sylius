<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Product;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;
use Sylius\Component\Review\Model\ReviewInterface;

interface ProductInterface extends BaseProductInterface
{
    /**
     * @return Collection|ReviewInterface[]
     *
     * @psalm-return Collection<array-key, ReviewInterface>
     */
    public function getAcceptedReviewsByCountryCode(
        string $countryCode
    ): Collection;
}
