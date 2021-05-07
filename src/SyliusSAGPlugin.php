<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusSAGPlugin extends Bundle
{
    use SyliusPluginTrait;
}
