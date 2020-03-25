<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusPplParcelshopsPlugin\Application\src\Entity\Shipping;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Table;
use MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShippingMethodInterface;
use MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShippingMethodTrait;
use Sylius\Component\Core\Model\ShippingMethod as BaseShippingMethod;

/**
 * @MappedSuperclass
 * @Table(name="sylius_shipping_method")
 */
class ShippingMethod extends BaseShippingMethod implements PplShippingMethodInterface
{
	use PplShippingMethodTrait;
}
