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
```

## Configure your Product

Your Product entity needs to implement the \Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface interface and use the \Dedi\SyliusSAGPlugin\Entity\Product\ProductTrait trait.

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
                model: Tests\Dedi\SyliusSAGPlugin\Application\src\Entity\Product\Product
```

## Configure the ProductReview

Your ProductReview entity needs to implement the \Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface interface and use the \Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewTrait trait.

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
}
```

Your ProductReviewRepository repository needs to implement the \Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryInterface interface and use the \Dedi\SyliusSAGPlugin\Repository\Review\ProductReviewRepositoryTrait trait.

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
                    model: Tests\Dedi\SyliusSAGPlugin\Application\src\Entity\Review\ProductReview
                    repository: Tests\Dedi\SyliusSAGPlugin\Application\src\Repository\Review\ProductReviewRepository
            reviewer:
                classes:
                    # configure the reviewer with this entity otherwise it will use the Customer entity
                    model: Sylius\Component\Review\Model\Reviewer
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

## Configure env variables

Add the followings to your `.env`, don't forget to use your values.

```dotenv
###> sag ###
DEDI_SAG_API_KEY=
DEDI_SAG_CERTIFICATE_OF_TRUTH_LINK=
###< sag ###
```
