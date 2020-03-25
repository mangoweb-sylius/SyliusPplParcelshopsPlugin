<p align="center">
    <a href="https://www.mangoweb.cz/en/" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/38423357?s=200&v=4"/>
    </a>
</p>
<h1 align="center">
    PPL parcelshops plugin
    <br />
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-ppl-parcelshops-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/mangoweb-sylius/sylius-ppl-parcelshops-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/mangoweb-sylius/sylius-ppl-parcelshops-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/mangoweb-sylius/sylius-ppl-parcelshops-plugin.svg" />
    </a>
    <a href="https://travis-ci.org/mangoweb-sylius/SyliusPplParcelshopsPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/mangoweb-sylius/SyliusPplParcelshopsPlugin/master.svg" />
    </a>
</h1>

## Features

 - Enables sending shipments via <a href="https://www.ppl.cz/main.aspx?cls=art&art_id=1685">PPL</a> to PPL parcelshops.
 - The user can choose the PPL parcelshops from the <a href="https://www.pplbalik.cz/Main3.aspx?cls=KTMMap">map</a> during checkout in the Shipment step. 
 - See PPL parcelshop in final checkout step and also in the admin panel.
 - Export CSV with the PPL parcelshops shipments and import it easily into PPL's system.

## Installation

1. Run `$ composer require mangoweb-sylius/sylius-ppl-parcelshops-plugin`.
1. Add plugin classes to your `config/bundles.php`:
 
   ```php
   return [
      ...
      MangoSylius\ShipmentExportPlugin\MangoSyliusShipmentExportPlugin::class => ['all' => true],
      MangoSylius\SyliusPplParcelshopsPlugin\MangoSyliusPplParcelshopsPlugin::class => ['all' => true],
   ];
   ```
   
1. Add routing to `config/_routes.yaml`

    ```yaml
    sylius_ppl_parcelshops_plugin:
        resource: '@MangoSyliusPplParcelshopsPlugin/Resources/config/routing.yml'
   
    mango_sylius_shipment_export_plugin:
        resource: '@MangoSyliusShipmentExportPlugin/Resources/config/routing.yml'
        prefix: /admin
    ```
   
1. Your Entity `Shipment` has to implement `\MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShipmentInterface`. 
   You can use the trait `\MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShipmentTrait`.
 
   ```php
   <?php 
   
   declare(strict_types=1);
   
   namespace App\Entity\Shipping;
   
   use Doctrine\ORM\Mapping as ORM;
   use MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShipmentInterface;
   use MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShipmentTrait;
   use Sylius\Component\Core\Model\Shipment as BaseShipment;
   
   /**
    * @ORM\Entity
    * @ORM\Table(name="sylius_shipment")
    */
   class Shipment extends BaseShipment implements PplShipmentInterface
   {
       use PplShipmentTrait;
   }
   ```
   
1. Your Entity `ShippingMethod` has to implement `\MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShippingMethodInterface`. 
   You can use the trait `\MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShippingMethodTrait`.
 
   ```php
   <?php 
   
   declare(strict_types=1);
   
   namespace App\Entity\Shipping;
   
   use Doctrine\ORM\Mapping as ORM;
   use MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShippingMethodInterface;
   use MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShippingMethodTrait;
   use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;
   
   /**
    * @ORM\Entity
    * @ORM\Table(name="sylius_shipping_method")
    */
   class ShippingMethod extends BaseShippingMethod implements PplShippingMethodInterface
   {
       use PplShippingMethodTrait;
   }
   ```

1. Include `@MangoSyliusPplParcelshopsPlugin/Admin/ShippingMethod/_pplForm.html.twig` into `@SyliusAdmin/ShippingMethod/_form.html.twig`.
 
    ```twig
    ...	
   {{ include('@MangoSyliusPplParcelshopsPlugin/Admin/ShippingMethod/_pplForm.html.twig') }}
    ```
   
1. Include `@MangoSyliusPplParcelshopsPlugin/Shop/Checkout/SelectShipping/_pplChoice.html.twig` into `@SyliusShop/Checkout/SelectShipping/_choice.html.twig`.
 
    ```twig
    ...
   {{ include('@MangoSyliusPplParcelshopsPlugin/Shop/Checkout/SelectShipping/_pplChoice.html.twig') }}
    ```
   
1. Replace `{% include '@SyliusShop/Common/_address.html.twig' with {'address': order.shippingAddress} %}` 
   with `{{ include('@MangoSyliusPplParcelshopsPlugin/Shop/Common/Order/_addresses.html.twig') }}` 
   in `@SyliusShop/Common/Order/_addresses.html.twig`

1. Replace `{% include '@SyliusAdmin/Common/_address.html.twig' with {'address': order.shippingAddress} %}` 
   with `{{ include('@MangoSyliusPplParcelshopsPlugin/Admin/Common/Order/_addresses.html.twig') }}` 
   in `@SyliusAdmin/Order/Show/_addresses.html.twig`

1. Override the template in `@MangoSyliusShipmentExportPlugin/_row.html.twig`
    ```twig
   {% extends '@MangoSyliusShipmentExportPlugin/_row.html.twig' %}
   
   {% block address %}
       {% if row.pplKTMID %}
          {{ include('@MangoSyliusPplParcelshopsPlugin/_exporterRow.html.twig') }}
       {% else %}
          {{ parent() }}
       {% endif %}
   {% endblock %}
    ```
   
1. Create and run doctrine database migrations.

For the guide how to use your own entity see [Sylius docs - Customizing Models](https://docs.sylius.com/en/1.7/customization/model.html)

## Usage

* For delivery to the PPL parcelshop, create new shipping method in the admin panel, check `To PPL ParcelShop enabled`.
* PPL CSV export will be generated for shipping method which has the code 'ppl_parcel_shop', you can change this in parameters, it is an array.
  ```yaml
  parameters:
      pplShippingMethodsCodes: ['ppl_parcel_shop']
  ```

## Development

### Usage

- Develop your plugin in `/src`
- See `bin/` for useful commands

### Testing


After your changes you must ensure that the tests are still passing.

```bash
$ composer install
$ bin/console doctrine:schema:create -e test
$ bin/behat
$ bin/phpstan.sh
$ bin/ecs.sh
```

License
-------
This library is under the MIT license.

Credits
-------
Developed by [manGoweb](https://www.mangoweb.eu/).
