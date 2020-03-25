<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusPplParcelshopsPlugin\Application\src\Entity\Shipping;

use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Table;
use MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShipmentInterface;
use MangoSylius\SyliusPplParcelshopsPlugin\Model\PplShipmentTrait;
use Sylius\Component\Core\Model\Shipment as BaseShipment;

/**
 * @MappedSuperclass
 * @Table(name="sylius_shipment")
 */
class Shipment extends BaseShipment implements PplShipmentInterface
{
	use PplShipmentTrait;
}
