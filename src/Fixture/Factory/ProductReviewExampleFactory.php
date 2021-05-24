<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Fixture\Factory;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use SM\Factory\FactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ProductReviewExampleFactory as BaseProductReviewExampleFactory;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Review\Factory\ReviewFactoryInterface;
use Sylius\Component\Review\Model\Reviewer;
use Sylius\Component\Review\Model\ReviewInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

class ProductReviewExampleFactory extends BaseProductReviewExampleFactory
{
    const CONTRY_CODES = [
        'fr',
        'en',
    ];

    /** @var \Faker\Generator */
    private $faker;

    /** @var OptionsResolver */
    private $optionsResolver;

    public function __construct(ReviewFactoryInterface $productReviewFactory, ProductRepositoryInterface $productRepository, CustomerRepositoryInterface $customerRepository, FactoryInterface $stateMachineFactory)
    {
        $this->faker = \Faker\Factory::create();

        parent::__construct($productReviewFactory, $productRepository, $customerRepository, $stateMachineFactory);

        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    public function create(array $options = []): ReviewInterface
    {
        $review =  parent::create($options);

        if (!$review instanceof ProductReviewInterface) {
            return $review;
        }

        $options = $this->optionsResolver->resolve($options);

        [
            'SAGId' => $SAGId,
            'SAGAnswerComment' => $SAGAnswerComment,
            'SAGAnswerCreatedAt' => $SAGAnswerCreatedAt,
            'SAGCountryCode' => $SAGCountryCode,
        ] = $options;

        Assert::nullOrString($SAGId);
        Assert::nullOrString($SAGAnswerComment);
        Assert::nullOrIsInstanceOf($SAGAnswerCreatedAt, \DateTimeInterface::class);
        Assert::nullOrString($SAGCountryCode);

        $review->setSAGId($SAGId);
        $review->setSAGAnswerComment($SAGAnswerComment);
        $review->setSAGAnswerCreatedAt($SAGAnswerCreatedAt);
        $review->setSAGCountryCode($SAGCountryCode);

        return $review;
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->remove('author')
            ->setDefault('author', function (Options $options): Reviewer {
                $reviewer = new Reviewer();
                $reviewer->setEmail($this->faker->email);
                $reviewer->setFirstName($this->faker->firstName);
                $reviewer->setLastName($this->faker->lastName);

                return $reviewer;
            })
            ->setDefault('SAGId', function (Options $options): string {
                return sprintf(
                    '#%s',
                    $this->faker->numerify('######'),
                );
            })
            ->setDefault('SAGAnswerComment', function (Options $options): string {
                return $this->faker->paragraph;
            })
            ->setDefault('SAGAnswerCreatedAt', function (Options $options): \DateTimeInterface {
                return $this->faker->dateTime;
            })
            ->setDefault('SAGCountryCode', function (Options $options): string {
                return (string) $this->faker->randomElement(self::CONTRY_CODES);
            })
        ;
    }
}
