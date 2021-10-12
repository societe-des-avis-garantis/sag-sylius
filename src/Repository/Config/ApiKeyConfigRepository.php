<?php

declare(strict_types=1);


namespace Dedi\SyliusSAGPlugin\Repository\Config;

use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ApiKeyConfigRepository extends EntityRepository implements ApiKeyConfigRepositoryInterface
{
    public function findOneByLocaleCodeAndChannelCode(
        string $localeCode,
        string $channelCode
    ): ?ApiKeyConfigInterface {
        /** @var ?ApiKeyConfigInterface $apiKeyConfig */
        $apiKeyConfig = $this->createQueryBuilder('o')
            ->join('o.locales', 'l')
            ->join('o.channels', 'c')
            ->where('l.code = :localeCode')
            ->setParameter('localeCode', $localeCode)
            ->andWhere('c.code = :channelCode')
            ->setParameter('channelCode', $channelCode)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $apiKeyConfig;
    }
}
