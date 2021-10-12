<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

class ApiContext implements ApiContextInterface
{
    /** @var string */
    private $checkTokenEndpoint;

    /** @var string */
    private $orderExportEndpoint;

    /** @var string */
    private $frDomain;

    /** @var string */
    private $enDomain;

    /** @var string */
    private $itDomain;

    /** @var string */
    private $esDomain;

    /** @var string */
    private $deDomain;

    /** @var string */
    private $defaultDomain;

    public function __construct(
        string $checkTokenEndpoint,
        string $orderExportEndpoint,
        string $frDomain,
        string $enDomain,
        string $itDomain,
        string $esDomain,
        string $deDomain,
        string $defaultDomain
    ) {
        $this->checkTokenEndpoint = $checkTokenEndpoint;
        $this->orderExportEndpoint = $orderExportEndpoint;
        $this->frDomain = $frDomain;
        $this->enDomain = $enDomain;
        $this->itDomain = $itDomain;
        $this->esDomain = $esDomain;
        $this->deDomain = $deDomain;
        $this->defaultDomain = $defaultDomain;
    }

    public function getUrl(
        string $endpointCode,
        string $countryCode
    ): string {
        return sprintf(
            '%s/%s',
            $this->getDomain($countryCode),
            $this->getEndPoint($endpointCode)
        );
    }

    protected function getDomain(string $countryCode): string
    {
        switch (strtolower($countryCode)) {
            case 'fr':
                return $this->frDomain;
            case 'en':
                return $this->enDomain;
            case 'it':
                return $this->itDomain;
            case 'es':
                return $this->esDomain;
            case 'de':
                return $this->deDomain;
            default:
                return $this->defaultDomain;
        }
    }

    protected function getEndPoint(string $endpointCode): string
    {
        switch ($endpointCode) {
            case self::ENDPOINT_CODE_CHECK_TOKEN:
                return $this->checkTokenEndpoint;
            case self::ENDPOINT_CODE_ORDER_EXPORT:
                return $this->orderExportEndpoint;
            default:
                throw new \LogicException(sprintf(
                    'Can\'t find endpoint for code "%s".',
                    $endpointCode
                ));
        }
    }
}
