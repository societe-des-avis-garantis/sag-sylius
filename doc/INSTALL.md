# Installation

Run `composer require dedi/sylius-sag-plugin --no-scripts`

Change your `config/bundles.php` file to add the line for the plugin :

```php
<?php

return [
    //..
    Dedi\SyliusSAGPlugin\DediSyliusSAGPlugin::class => ['all' => true],
];
```

## Configuration

Create `dedi_sag_plugin.yaml` file into `config/packages` folder to import required config

```yaml
# config/packages/dedi_sag_plugin.yaml

imports:
    - { resource: "@DediSyliusSAGPlugin/Resources/config/config.yml" }
```

## Routing

Add the plugin routes to your config.

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

## Configure your Product

Your `Product` entity needs to implement the `Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface` interface and use the `Dedi\SyliusSAGPlugin\Entity\Product\ProductTrait` trait.

```php
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

Don't forget to update the Sylius resource config accordingly.

```yaml
# config/_sylius.yaml

sylius_product:
    resources:
        product:
            classes:
                model: App\Entity\Product\Product
```

## Configure the ProductReview

Your `ProductReview` entity needs to implement the `Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface` interface and use the `Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewTrait` trait.

```php
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
                    model: App\Entity\Review\ProductReview
                    repository: App\Repository\Review\ProductReviewRepository
            reviewer:
                classes:
                    # configure the reviewer with this entity otherwise it will use the Customer entity
                    model: Sylius\Component\Review\Model\Reviewer
```

Your `ProductReviewFactory` should implement `Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryInterface` and use the `Dedi\SyliusSAGPlugin\Factory\Review\ReviewFactoryTrait` trait. 

```php
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

## Configure the Order

Your `OrderRepository` repository needs to implement the `Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryInterface` interface and use the `Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryTrait` trait.

```php
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

### Create migration

Create migration, review and execute them

```shell
bin/console doctrine:migration:diff
bin/console doctrine:migration:migrate
```

## Templates

Override sylius default templates.

```shell
cp -R vendor/dedi/sylius-sag-plugin/test/Application/templates/* templates/
```
