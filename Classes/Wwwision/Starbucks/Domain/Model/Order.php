<?php
namespace Wwwision\Starbucks\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Wwwision.Starbucks".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * An Order
 *
 * @Flow\Entity
 */
class Order {

	/**
	 * @var \Wwwision\Starbucks\Domain\Model\Drink
	 * @ORM\ManyToOne
	 */
	protected $drink;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\Wwwision\Starbucks\Domain\Model\Addition>
	 * @ORM\ManyToMany
	 */
	protected $additions;

	/**
	 * @var \Doctrine\Common\Collections\Collection<\Wwwision\Starbucks\Domain\Model\Payment>
	 * @ORM\OneToMany(mappedBy="relatedOrder")
	 */
	protected $payments;

	/**
	 * Constructor
	 *
	 * @param \Wwwision\Starbucks\Domain\Model\Drink $drink
	 * @param \Doctrine\Common\Collections\Collection<\Wwwision\Starbucks\Domain\Model\Addition> $additions
	 */
	public function __construct(Drink $drink, Collection $additions = NULL) {
		$this->drink = $drink;
		if ($additions !== NULL) {
			$this->additions = $additions;
		} else {
			$this->additions = new ArrayCollection();
		}
		$this->payments = new ArrayCollection();
	}

	/**
	 * @return \Wwwision\Starbucks\Domain\Model\Drink
	 */
	public function getDrink() {
		return $this->drink;
	}

	/**
	 * @param Collection<Addition> $additions
	 * @return void
	 */
	public function setAdditions(Collection $additions) {
		$this->additions = $additions;
	}

	/**
	 * @param Addition $addition
	 * @return void
	 */
	public function addAddition(Addition $addition) {
		$this->additions->add($addition);
	}

	/**
	 * @param Addition $addition
	 * @return void
	 */
	public function removeAddition(Addition $addition) {
		$this->additions->removeElement($addition);
	}

	/**
	 * @return Collection<Addition>
	 */
	public function getAdditions() {
		return $this->additions;
	}

	/**
	 * Calculates the price of the ordered drink and it's additions
	 *
	 * @return float
	 */
	public function getCost() {
		$cost = $this->drink->getCost();
		/** @var $addition Addition */
		foreach ($this->additions as $addition) {
			$cost += $addition->getCost();
		}
		return $cost;
	}

	/**
	 * @return Collection<Payment>
	 */
	public function getPayments() {
		return $this->payments;
	}

	/**
	 * @return boolean
	 */
	public function isPayed() {
		return $this->payments->count() > 0;
	}
}
?>