<?php

declare(strict_types=1);


namespace Dedi\SyliusSAGPlugin\Repository\Config;

use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;
use Dedi\SyliusSAGPlugin\Entity\Channel\ChannelInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Locale\Model\LocaleInterface;

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

    public function countFindWithSimilarConfiguration($id, array $locales, array $channels): int
    {
        $qb = $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->join('o.locales', 'l')
            ->join('o.channels', 'c')
            ->andWhere('l.id IN (:localeIds)')
            ->andWhere('c.id IN (:channelIds)')
            ->setParameter(':localeIds', array_map(function (LocaleInterface $locale) {
                return $locale->getId();
            }, $locales))
            ->setParameter(':channelIds', array_map(function (ChannelInterface $channel) {
                return $channel->getId();
            }, $channels))
        ;

        if (null !== $id) {
            $qb->andWhere('o.id != :id')
                ->setParameter('id', $id)
            ;
        }

        return (int) $qb->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function findOneByCountryCode(string $code): ?ApiKeyConfigInterface
    {
        /** @var ?ApiKeyConfigInterface $apiKeyConfig */
        $apiKeyConfig = $this->createQueryBuilder('o')
            ->andWhere('o.apiKey LIKE :apiKey')
            ->setParameter('apiKey', '%/'.$code.'/%')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $apiKeyConfig;
    }
}
