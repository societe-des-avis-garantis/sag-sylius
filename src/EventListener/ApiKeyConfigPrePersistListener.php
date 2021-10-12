<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\EventListener;

use Dedi\SyliusSAGPlugin\Api\CertificateOfTruthUrlFetcherInterface;
use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;

class ApiKeyConfigPrePersistListener
{
    /** @var CertificateOfTruthUrlFetcherInterface */
    private $certificateOfTruthUrlFetcher;

    public function __construct(
        CertificateOfTruthUrlFetcherInterface $certificateOfTruthUrlFetcher
    ) {
        $this->certificateOfTruthUrlFetcher = $certificateOfTruthUrlFetcher;
    }

    public function __invoke(ResourceControllerEvent $event): void
    {
        $apiKey = $event->getSubject();
        if (!$apiKey instanceof ApiKeyConfigInterface) {
            throw new \LogicException(sprintf('Subject should be an instance of %s', ApiKeyConfigInterface::class));
        }

        $url = $this->certificateOfTruthUrlFetcher->__invoke($apiKey);
        $apiKey->setCertificateOfTruthUrl($url);
    }
}

