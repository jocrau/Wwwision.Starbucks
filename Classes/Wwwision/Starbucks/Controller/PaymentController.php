<?php
namespace Wwwision\Starbucks\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Wwwision.Starbucks".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Wwwision\Starbucks\Domain\Model\Order;
use Wwwision\Starbucks\Domain\Model\Payment;

/**
 * Controller for the ``payment`` domain object
 *
 * @Flow\Scope("singleton")
 */
class PaymentController extends \TYPO3\Flow\Mvc\Controller\AbstractRestController {

	/**
	 * A list of IANA media types which are supported by this controller
	 *
	 * @var array
	 * @see http://www.iana.org/assignments/media-types/index.html
	 */
	protected $supportedMediaTypes = array('application/xml');

	/**
	 * Controller for the order domain object
	 *
	 * @var string
	 * @see \TYPO3\Flow\Mvc\Controller\RestController
	 */
	protected $resourceArgumentName = 'payment';

	/**
	 * @Flow\Inject
	 * @var \Wwwision\Starbucks\Domain\Repository\PaymentRepository
	 */
	protected $paymentRepository;

	/**
	 * @Flow\Inject
	 * @var \Wwwision\Starbucks\Domain\Repository\OrderRepository
	 */
	protected $orderRepository;

	/**
	 * @return void
	 */
	public function listAction() {
		$this->view->assign('payments', $this->paymentRepository->findAll());
	}

	/**
	 * @param \Wwwision\Starbucks\Domain\Model\Payment $payment
	 * @return void
	 */
	public function showAction(Payment $payment) {
		$this->view->assign('payment', $payment);
	}

	/**
	 * @param \Wwwision\Starbucks\Domain\Model\Order $order
	 * @param \Wwwision\Starbucks\Domain\Model\Payment $payment
	 * @return void
	 */
	public function createAction(Order $order, Payment $payment) {
		$payment->setRelatedOrder($order);
		$this->paymentRepository->add($payment);
		$this->response->setStatus(201);
		$this->view->assign('payment', $payment);
		$this->redirectToResource($payment, 303, array('order' => $order));
	}

	/**
	 * @param \Wwwision\Starbucks\Domain\Model\Payment $payment
	 * @return void
	 */
	public function updateAction(Payment $payment) {
		$this->paymentRepository->update($payment);
		$this->forwardToResource($payment);
	}

	/**
	 * @param \Wwwision\Starbucks\Domain\Model\Payment $payment
	 * @return void
	 */
	public function deleteAction(Payment $payment) {
		$this->orderRepository->remove($payment);
		$this->redirectToResource();
	}

}

?>