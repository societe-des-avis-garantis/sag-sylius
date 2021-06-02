<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Channel;

use Doctrine\ORM\Mapping as ORM;

trait ChannelTrait
{
    /** @ORM\Column(type="boolean", name="sag_show_iframe_widget", nullable=false, options={"default" : 1}) */
    protected $SAGShowIframeWidget;

    /** @ORM\Column(type="boolean", name="sag_show_footer_certificate_link", nullable=false, options={"default" : 1}) */
    protected $SAGShowFooterCertificateLink;

    public function getSAGShowIframeWidget(): bool
    {
        return $this->SAGShowIframeWidget;
    }

    public function setSAGShowIframeWidget(bool $SAGShowIframeWidget): ChannelInterface
    {
        $this->SAGShowIframeWidget = $SAGShowIframeWidget;

        return $this;
    }

    public function getSAGShowFooterCertificateLink(): bool
    {
        return $this->SAGShowFooterCertificateLink;
    }

    public function setSAGShowFooterCertificateLink(bool $SAGShowFooterCertificateLink): ChannelInterface
    {
        $this->SAGShowFooterCertificateLink = $SAGShowFooterCertificateLink;

        return $this;
    }
}
