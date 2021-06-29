<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Validator;

use Dedi\SyliusSAGPlugin\Entity\ApiKeyConfigInterface;
use Dedi\SyliusSAGPlugin\Repository\Config\ApiKeyConfigRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ApiKeyConfigIsUniqueForLocalesAndChannelsValidator extends ConstraintValidator
{
    /** @var ApiKeyConfigRepositoryInterface */
    private $apiKeyConfigRepository;

    public function __construct(
        ApiKeyConfigRepositoryInterface $apiKeyConfigRepository
    ) {
        $this->apiKeyConfigRepository = $apiKeyConfigRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ApiKeyConfigIsUniqueForLocalesAndChannels) {
            throw new UnexpectedTypeException($constraint, ApiKeyConfigIsUniqueForLocalesAndChannels::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!$value instanceof ApiKeyConfigInterface) {
            throw new UnexpectedValueException($value, ApiKeyConfigInterface::class);
        }

        $count = $this->apiKeyConfigRepository->countFindWithSimilarConfiguration(
            $value->getId(),
            $value->getLocales()->toArray(),
            $value->getChannels()->toArray(),
        );

        if ($count === 0) {
            return;
        }

        $this->context->buildViolation('dedi_sylius_sag_plugin.non_unique_for_locales_and_channels')
            ->addViolation()
        ;
    }
}
