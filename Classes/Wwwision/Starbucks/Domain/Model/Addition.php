<?php
namespace Wwwision\Starbucks\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Wwwision.Starbucks".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Drink addition
 *
 * @Flow\Entity
 */
class Addition {

	/**
	 * @var string
	 * @ORM\Id
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * Price of this addition
	 *
	 * @var float
	 */
	protected $cost;

	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param float $cost
	 */
	public function __construct($name, $cost) {
		$this->name = $name;
		$this->cost = (float)$cost;
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
	 * @return string
	 */
	public function __toString() {
		return $this->name;
	}

}
?>