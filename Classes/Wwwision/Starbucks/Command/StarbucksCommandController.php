<?php
namespace Wwwision\Starbucks\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Wwwision.Starbucks".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Wwwision\Starbucks\Domain\Model;

/**
 * Simple Command controller that supports dummy data & workflows to be initiated from CLI
 *
 * @Flow\Scope("singleton")
 */
class StarbucksCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Inject
	 * @var \Wwwision\Starbucks\Domain\Repository\DrinkRepository
	 */
	protected $drinkRepository;

	/**
	 * @Flow\Inject
	 * @var \Wwwision\Starbucks\Domain\Repository\OrderRepository
	 */
	protected $orderRepository;

	/**
	 * @Flow\Inject
	 * @var \Wwwision\Starbucks\Domain\Repository\PaymentRepository
	 */
	protected $paymentRepository;

	/**
	 * @return void
	 */
	public function setupCommand() {
		$milk = new Model\Addition('Milk', 1.00);
		$cream = new Model\Addition('Cream', 0.50);
		$cream = new Model\Addition('Shot', 1.00);

		$latte = new Model\Drink('Latte', 3.00);
		$latte->addAvailableAddition($milk);
		$latte->addAvailableAddition($cream);

		$this->drinkRepository->add($latte);

		$this->outputLine('Dummy data created!');
	}

	/**
	 * @param \Wwwision\Starbucks\Domain\Model\Drink $drink
	 * @return void
	 */
	public function orderCommand(Model\Drink $drink) {
		$order = new Model\Order($drink);
		$this->orderRepository->add($order);

		$this->outputLine('Order "%s" created!', array($this->persistenceManager->getIdentifierByObject($order)));
	}

	/**
	 * @param \Wwwision\Starbucks\Domain\Model\Order $order
	 * @param string $cardNo
	 * @param string $expires
	 * @param string $name
	 * @param float $amount
	 * @return void
	 */
	public function payCommand(Model\Order $order, $cardNo, $expires, $name, $amount) {
		$payment = new Model\Payment($order);
		$payment->setCardNo($cardNo);
		$payment->setExpires($expires);
		$payment->setName($name);
		$payment->setAmount($amount);
		$this->paymentRepository->add($payment);

		$this->outputLine('Payment created!');
	}

}

?>