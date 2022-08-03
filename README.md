<p align="center">
    <a href="https://sylius.com" target="_blank">
        <img src="https://demo.sylius.com/assets/shop/img/logo.png" width="600" height="200" alt="sylius-logo" />
    </a>
</p>

<h1 align="center">Plugin SAG</h1>

<p align="center">Sylius SAG plugin by Dedi. Product review integration for <a href="https://www.societe-des-avis-garantis.fr/">Société des Avis Garantis</a></p>

<h2>About Dedi</h2>

<p align="center">
    <a href="https://www.dedi-agency.com" target="_blank">
        <img src="https://www.dedi-agency.com/wp-content/uploads/2014/05/Dedi_logo_HD.png" />
    </a>
</p>

<p>

At Dedi, we do not just create websites. We are building together a real digital strategy to combine your business requirements with our technical skills. We've been working with open source for a long time and decided to start giving back to the community by contributing and sharing some plugin of our own.

We’ll be happy to meet you, feel free to contact us. Learn more about us on our <a href="https://www.dedi-agency.com" target="_blank">website</a>.
</p>

---
## Table of Content

* [Installation](#installation)
* [Configure Product](#configure-product)
* [Configure Product Review](#configure-productreview)
* [Configure Order](#configure-order)
* [Configure Channel](#configure-channel)
* [Migrations](#create-migration)
* [Templates](#templates)
* [Overview](#overview)

# Installation
Require plugin with composer:

```bash
composer require societe-des-avis-garantis/sylius-sag-plugin --no-scripts
```

Symfony Flex will automatically register and configure the `config/bundles.php` file to add the line for the plugin :

```php
<?php

return [
    //..
    Dedi\SyliusSAGPlugin\DediSyliusSAGPlugin::class => ['all' => true],
];
```

* Create a `dedi_sag_plugin.yaml` file into `config/packages` folder to import required config

```yaml
# config/packages/dedi_sag_plugin.yaml

imports:
    - { resource: "@DediSyliusSAGPlugin/Resources/config/config.yml" }
```

* Add the plugin routes to your config.

```yaml
# config/routes.yaml

dedi_sylius_sag_shop:
    resource: "@DediSyliusSAGPlugin/Resources/config/shop_routing.yml"
    prefix: /{_locale}
    requirements:
        _locale: ^[a-z]{2}(?:_[A-Z]{2})?$

dedi_sylius_sag_admin:
    resource: "@DediSyliusSAGPlugin/Resources/config/admin_routing.yml"
    prefix: /admin

dedi_sylius_sag_api:
    resource: "@DediSyliusSAGPlugin/Resources/config/api_routing.yml"
    prefix: /sag-api
```

# Configure Product

Your `Product` entity needs to implement the `Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface` interface and use the `Dedi\SyliusSAGPlugin\Entity\Product\ProductTrait` trait.

```php
<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface as DediSAGProductInterface;
use Dedi\SyliusSAGPlugin\Entity\Product\ProductTrait as DediSAGProductTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements DediSAGProductInterface
{
    use DediSAGProductTrait;
}
```

# Configure ProductReview

Your `ProductReview` entity needs to implement the `Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface` interface and use the `Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewTrait` trait.

```php
<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface as DediSAGProductReviewInterface;
use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewTrait as DediSAGProductReviewTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductReview as BaseProductReview;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_review")
 */
class ProductReview extends BaseProductReview implements DediSAGProductReviewInterface
{
    use DediSAGProductReviewTrait;
    
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
```

Your `ProductReviewRepository` repository needs to implement the `Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryInterface` interface and use the `Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryTrait` trait.

```php
<?php

declare(strict_types=1);

namespace App\Repository\Review;

use Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryInterface as DediSAGProductReviewRepositoryInterface;
use Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryTrait as DediSAGProductReviewRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductReviewRepository as BaseProductReviewRepository;

final class ProductReviewRepository extends BaseProductReviewRepository implements DediSAGProductReviewRepositoryInterface
{
    use DediSAGProductReviewRepositoryTrait;
}
```

Don't forget to update the Sylius resource config accordingly.

```yaml
# config/_sylius.yaml

sylius_review:
    resources:
        product:
            review:
                classes:
                    model: App\Entity\Product\ProductReview
                    repository: App\Repository\Review\ProductReviewRepository
            reviewer:
                classes:
                    # configure the reviewer with this entity otherwise it will use the Customer entity
                    model: Sylius\Component\Review\Model\Reviewer
```

Your `ProductReviewFactory` should implement `Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryInterface` and use the `Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryTrait` trait.

```php
<?php

declare(strict_types=1);

namespace App\Factory\Review;

use Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryInterface as DediSAGReviewFactoryInterface;
use Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryTrait as DediSAGReviewFactoryTrait;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Review\Factory\ReviewFactoryInterface;
use Sylius\Component\Review\Model\ReviewableInterface;
use Sylius\Component\Review\Model\ReviewerInterface;
use Sylius\Component\Review\Model\ReviewInterface;

final class ReviewFactory implements DediSAGReviewFactoryInterface
{
    use DediSAGReviewFactoryTrait {
        __construct as initializeDediSAGArguments;
    }

    /** @var ReviewFactoryInterface */
    private $baseFactory;

    public function __construct(
        ReviewFactoryInterface $baseFactory,
        FactoryInterface $reviewerFactory
    ) {
        $this->baseFactory = $baseFactory;

        $this->initializeDediSAGArguments($reviewerFactory);
    }

    public function createNew()
    {
        return $this->baseFactory->createNew();
    }

    public function createForSubject(ReviewableInterface $subject): ReviewInterface
    {
        return $this->baseFactory->createForSubject($subject);
    }

    public function createForSubjectWithReviewer(ReviewableInterface $subject, ?ReviewerInterface $reviewer): ReviewInterface
    {
        return $this->baseFactory->createForSubjectWithReviewer($subject, $reviewer);
    }
}
```

Don't forget to add the corresponding service.

```yaml
# config/services.yaml

services:
    app.factory.product_review:
        class: App\Factory\Review\ReviewFactory
        decorates: sylius.factory.product_review
        arguments:
            $baseFactory: '@app.factory.product_review.inner'
            $reviewerFactory: '@sylius.factory.product_reviewer'
        public: false
```

## Configure Order

Your `OrderRepository` repository needs to implement the `Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryInterface` interface and use the `Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryTrait` trait.

```php
<?php

declare(strict_types=1);

namespace App\Repository\Order;

use Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryInterface as DediSAGOrderRepositoryInterface;
use Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryTrait as DediSAGOrderRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

class OrderRepository extends BaseOrderRepository implements DediSAGOrderRepositoryInterface
{
    use DediSAGOrderRepositoryTrait;
}
```

Don't forget to update the Sylius resource config accordingly.

```yaml
# config/_sylius.yaml

sylius_order:
    resources:
        order:
            classes:
                repository: App\Repository\Order\OrderRepository
```

# Configure Channel

Your `Channel` entity needs to implement the `Dedi\SyliusSAGPlugin\Entity\Channel\ChannelInterface` interface and use the `Dedi\SyliusSAGPlugin\Entity\Channel\ChannelTrait` trait.

```php
<?php

declare(strict_types=1);

namespace App\Entity\Channel;

use Dedi\SyliusSAGPlugin\Entity\Channel\ChannelInterface as DediSAGChannelInterface;
use Dedi\SyliusSAGPlugin\Entity\Channel\ChannelTrait as DediSAGChannelTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_channel")
 */
class Channel extends BaseChannel implements DediSAGChannelInterface
{
    use DediSAGChannelTrait;
}
```

# Create migration

Migrations are already provided by the plugin itself.

```shell
bin/console doctrine:migration:migrate
```

# Templates

Override sylius default templates.

```shell
cp -R vendor/dedi/sylius-sag-plugin/tests/Application/templates/* templates/
```

# Overview

### Product Index

This plugin adds the following features to your shop:
* Javascript widget
* Iframe widget
* footer certificate link

![docs/img/shop_product_index.png](doc/img/shop_product_index.png)

### Product Show

On your product page, you will retrieve reviews from Societé des Avis Garantis with some statistics.

![docs/img/shop_product_show.png](doc/img/shop_product_show.png)

### Admin Key Index

In the back office, a new entry "SAG Api keys" allows you to configure your shop with Société des Avis Garantis api.

![docs/img/admin_key_index.png](doc/img/admin_key_index.png)

![docs/img/admin_key_edit.png](doc/img/admin_key_edit.png)

### Admin Channel configuration

The channel configuration form gets a new section where you can enable or disable the following parts on your shop:
* Javascript widget
* Iframe widget
* footer certificate link

![docs/img/admin_channel_edit.png](doc/img/admin_channel_edit.png)

### Admin Reviews

Reviews are now not editable in the back office to comply with Société des Avis Garantis requirements.

![docs/img/admin_review_index.png](doc/img/admin_review_index.png)

