<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model;

class ApiKey
{
    /** @var int */
    private $idSite;

    /** @var string */
    private $languageCode;

    /** @var string */
    private $key;

    public function __construct(
        int $idSite,
        string $languageCode,
        string $key
    ) {
        $this->idSite = $idSite;
        $this->languageCode = $languageCode;
        $this->key = $key;
    }

    public function getIdSite(): int
    {
        return $this->idSite;
    }

    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getApiKey(): string
    {
        return implode('/', [
            $this->idSite,
            $this->languageCode,
            $this->key,
        ]);
    }
}
