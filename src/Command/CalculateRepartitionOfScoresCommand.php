<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Command;

use Dedi\SyliusSAGPlugin\Calculator\RepartitionOfScoresCalculatorInterface;
use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CalculateRepartitionOfScoresCommand extends Command
{
    protected static $defaultName = 'dedi-sag:calculate-repartition-of-scores';

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var RepartitionOfScoresCalculatorInterface */
    private $repartitionOfScoresCalculator;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        RepartitionOfScoresCalculatorInterface $repartitionOfScoresCalculator,
        EntityManagerInterface $em
    ) {
        parent::__construct();

        $this->productRepository = $productRepository;
        $this->repartitionOfScoresCalculator = $repartitionOfScoresCalculator;
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->setName(self::$defaultName)
            ->setDescription('Calculates the repartition of scores.')
            ->setHelp('This command re-calculates all the repartition of scores for each products')
            ->addArgument('country-code', InputArgument::REQUIRED, 'Country code, ex: fr')
            ->addOption('batch-size', 'bs', InputArgument::OPTIONAL, 'Defines how many products are updated at once.', 10)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->productRepository->findAll();
        $countryCode = $input->getArgument('country-code');
        $batchSize = $input->getOption('batch-size');
        $i = 0;

        /** @var ProductInterface $product */
        foreach ($products as $product) {
            $repartitionOfScores = $this->repartitionOfScoresCalculator->__invoke($product, $countryCode);
            $this->em->persist($repartitionOfScores);

            if (($i % $batchSize) === 0) {
                $this->em->flush();
            }

            $i++;
        }

        $this->em->flush();

        return 0;
    }
}
