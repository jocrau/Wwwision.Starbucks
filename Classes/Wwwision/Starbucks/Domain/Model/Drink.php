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
 * A Drink
 *
 * @Flow\Entity
 */
class Drink {

	/**
	 * @var string
	 * @ORM\Id
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * Cost of this drink (without additions)
	 *
	 * @var float
	 */
	protected $cost;

	/**
	 * All additions that are allowed to add to this drink
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Wwwision\Starbucks\Domain\Model\Addition>
	 * @ORM\ManyToMany(cascade={"persist"})
	 */
	protected $availableAdditions;

	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param float $cost
	 */
	public function __construct($name, $cost) {
		$this->name = $name;
		$this->cost = (float)$cost;
		$this->availableAdditions = new ArrayCollection();
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param float $cost
	 * @return void
	 */
	public function setCost($cost) {
		$this->cost = (float)$cost;
	}

	/**
	 * @return float
	 */
	public function getCost() {
		return $this->cost;
	}

	/**
	 * @param Collection<Addition> $additions
	 * @return void
	 */
	public function setAvailableAdditions(Collection $additions) {
		$this->availableAdditions = $additions;
	}

	/**
	 * @param Addition $addition
	 * @return void
	 */
	public function addAvailableAddition(Addition $addition) {
		$this->availableAdditions->add($addition);
	}

	/**
	 * @param Addition $addition
	 * @return void
	 */
	public function removeAvailableAddition(Addition $addition) {
		$this->availableAdditions->removeElement($addition);
	}

	/**
	 * @return Collection<Addition>
	 */
	public function getAvailableAdditions() {
		return $this->availableAdditions;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->name;
	}

}
?>