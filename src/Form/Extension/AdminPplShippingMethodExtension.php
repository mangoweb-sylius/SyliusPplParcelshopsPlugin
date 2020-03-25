<?php

declare(strict_types=1);

namespace MangoSylius\SyliusPplParcelshopsPlugin\Form\Extension;

use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminPplShippingMethodExtension extends AbstractTypeExtension
{
	/** @var array<string> */
	private $countryChoices;

	/**
	 * @param array<string> $countryChoices
	 */
	public function __construct(
		array $countryChoices
	) {
		$this->countryChoices = $countryChoices;
	}

	/** @return array<int, string> */
	public static function getExtendedTypes(): array
	{
		return [
			ShippingMethodType::class,
		];
	}

	/** @param array<mixed> $options */
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('pplParcelshopsShippingMethod', CheckboxType::class, [
				'label' => 'mangoweb.admin.pplParcelShop.form.pplParcelshopsShippingMethod',
				'required' => false,
			])
			->add('pplOptionCountry', ChoiceType::class, [
				'label' => 'mangoweb.admin.pplParcelShop.form.pplOptionCountry',
				'required' => false,
				'choices' => array_combine($this->countryChoices, $this->countryChoices),
				'multiple' => false,
				'expanded' => false,
			]);
	}
}
