<?php
namespace Wwwision\Starbucks\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Wwwision.Starbucks".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Payment
 *
 * @Flow\Entity
 */
class Payment {

	/**
	 * @var \Wwwision\Starbucks\Domain\Model\Order
	 * @ORM\ManyToOne
	 */
	protected $relatedOrder;

	/**
	 * @var string
	 */
	protected $cardNo;

	/**
	 * @var string
	 */
	protected $expires;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var float
	 */
	protected $amount = 0.0;

	/**
	 * @param \Wwwision\Starbucks\Domain\Model\Order $relatedOrder
	 * @return void
	 */
	public function setRelatedOrder(Order $relatedOrder) {
		$this->relatedOrder = $relatedOrder;
	}

	/**
	 * @return \Wwwision\Starbucks\Domain\Model\Order
	 */
	public function getRelatedOrder() {
		return $this->relatedOrder;
	}

	/**
	 * @param string $cardNo
	 * @return void
	 */
	public function setCardNo($cardNo) {
		$this->cardNo = $cardNo;
	}

	/**
	 * @return string
	 */
	public function getCardNo() {
		return $this->cardNo;
	}

	/**
	 * @param string $expires
	 * @return void
	 */
	public function setExpires($expires) {
		$this->expires = $expires;
	}

	/**
	 * @return string
	 */
	public function getExpires() {
		return $this->expires;
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
	 * @param float $amount
	 * @return void
	 */
	public function setAmount($amount) {
		$this->amount = (float)$amount;
	}

	/**
	 * @return float
	 */
	public function getAmount() {
		return $this->amount;
	}

}
?>