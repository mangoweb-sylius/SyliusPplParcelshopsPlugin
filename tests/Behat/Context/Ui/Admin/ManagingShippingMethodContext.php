<?php

declare(strict_types=1);

namespace Tests\MangoSylius\SyliusPplParcelshopsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Tests\MangoSylius\SyliusPplParcelshopsPlugin\Behat\Page\Admin\ShippingMethod\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingShippingMethodContext implements Context
{
	/** @var UpdatePageInterface */
	private $updatePage;

	public function __construct(
		UpdatePageInterface $updatePage
	) {
		$this->updatePage = $updatePage;
	}

	/**
	 * @Then it should be shipped to PPL parcelshop
	 */
	public function ttShouldBeShippedToPplParcelshop()
	{
		Assert::true($this->updatePage->iSeePplParcelshopInsteadOfShippingAddress());
	}

	/**
	 * @When I enable PPL parcelshops
	 */
	public function iEnablePplParcelshops()
	{
		$this->updatePage->enablePplParcelshops();
	}

	/**
	 * @Then the PPL parcelshops shoul be enabled
	 */
	public function thePplParcelshopsShoulBeEnabled()
	{
		Assert::true((bool) $this->updatePage->isSingleResourceOnPage('pplCheckbox'));
	}

	/**
	 * @When I disable PPL parcelshops
	 */
	public function iDisablePplParcelshops()
	{
		$this->updatePage->disablePplParcelshops();
	}

	/**
	 * @Then the PPL parcelshops shoul be disabled
	 */
	public function thePplParcelshopsShoulBeDisabled()
	{
		Assert::false((bool) $this->updatePage->isSingleResourceOnPage('pplCheckbox'));
	}
}
