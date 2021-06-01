<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Api;

use Dedi\SyliusSAGPlugin\Context\ApiContextInterface;
use Dedi\SyliusSAGPlugin\Context\ApiKeyContextInterface;
use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryInterface;
use Dedi\SyliusSAGPlugin\Model\Api\FetchReviewsRequest;
use Dedi\SyliusSAGPlugin\Model\Api\ReviewDTO;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Review\Model\ReviewableInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ReviewFetcher implements ReviewFetcherInterface
{
    /** @var HttpClientInterface */
    private $client;

    /** @var LoggerInterface */
    private $logger;

    /** @var ApiKeyContextInterface */
    private $apiKeyContext;

    /** @var ApiContextInterface */
    private $apiContext;

    /** @var ReviewFactoryInterface */
    private $reviewFactory;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * @var string
     *
     * @psalm-var class-string
     */
    private $productClass;

    public function __construct(
        HttpClientInterface $client,
        LoggerInterface $logger,
        ApiKeyContextInterface $apiKeyContext,
        ApiContextInterface $apiContext,
        ReviewFactoryInterface $reviewFactory,
        EntityManagerInterface $em,
        string $productClass
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->apiKeyContext = $apiKeyContext;
        $this->apiContext = $apiContext;
        $this->reviewFactory = $reviewFactory;
        $this->em = $em;
        /** @psalm-var class-string $productClass */
        $this->productClass = $productClass;
    }

    public function __invoke(FetchReviewsRequest $request): array
    {
        $apiKey = $this->apiKeyContext->findApiKeyByCountryCode($request->getCountryCode());
        if (null === $apiKey) {
            $message = sprintf(
                'ApiKey not found for country code: "%s".',
                $request->getCountryCode(),
            );

            $this->logger->error($message, [
                'request' => $request,
            ]);

            throw new \LogicException($message);
        }

        try {
            $response = $this->client->request('POST', $this->getUrl($request->getCountryCode()), [
                'body' => [
                    'apiKey' => $apiKey->getApiKey()
                ],
                'query' => array_merge([
                    'apiPost' => 1,
                ], $request->getQueryParams()),
                'timeout' => 30,
            ]);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(
                sprintf(
                    'Error while fetching reviews: "%s".',
                    $e->getMessage(),
                ), [
                'exception' => $e,
                'request' => $request,
            ]);

            throw $e;
        }

        try {
            $data = $response->toArray();
        } catch (\Exception $e) {
            $this->logger->error(sprintf(
                'Error while transforming reviews response to array: "%s"',
                $e->getMessage(),
            ), [
                'exception' => $e,
                'request' => $request,
                'responseContent' => $response->getContent(false),
            ]);

            throw $e;
        }

        $reviews = array_map(function (array $datum): ?ProductReviewInterface {
            try {
                /** @var ReviewableInterface $product */
                $product = $this->em->find($this->productClass, (int) $datum['idProduct']);

                $dto = new ReviewDTO(
                    (string) $datum['idSAG'],
                    $product,
                    (int) $datum['review_rating'],
                    (string) $datum['review_text'],
                    (string) $datum['reviewer_name'],
                    (string) $datum['lastname'],
                    new \DateTimeImmutable((string) $datum['date_time']),
                    (int) $datum['review_status'],
                    null === $datum['answer_text'] ? null : (string) $datum['answer_text'],
                    array_key_exists('answer_date_time', $datum) && null !== $datum['answer_date_time'] ? new \DateTimeImmutable((string) $datum['answer_date_time']) : null,
                    array_key_exists('order_date', $datum) && null !== $datum['order_date'] ? new \DateTimeImmutable((string) $datum['order_date']) : null,
                    (string) $datum['lang']
                );

                return $this->reviewFactory->buildFromDTO($dto);
            } catch (\Exception $e) {
                $this->logger->error(
                    sprintf('Error creating a Review entity with data: "%s".', $e->getMessage()),
                    [
                        'data' => $datum,
                        'exception' => $e,
                    ]
                );

                return null;
            }
        }, $data);

        return array_filter($reviews, static function (?ProductReviewInterface $review): bool {
            return null !== $review;
        });
    }

    private function getUrl(string $countryCode): string
    {
        return sprintf(
            '%s/wp-content/plugins/ag-core/api/reviews.php',
            $this->apiContext->getDomain($countryCode)
        );
    }
}
