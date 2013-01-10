<?php
namespace Wwwision\Starbucks\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Wwwision.Starbucks".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Wwwision\Starbucks\Domain\Model\Order;

/**
 * Controller for the ``order`` domain object
 *
 * @Flow\Scope("singleton")
 */
class OrderController extends \TYPO3\Flow\Mvc\Controller\AbstractRestController {

	/**
	 * A list of IANA media types which are supported by this controller
	 *
	 * @var array
	 * @see http://www.iana.org/assignments/media-types/index.html
	 */
	protected $supportedMediaTypes = array('application/xml');

	/**
	 * Name of this resource in requests
	 *
	 * @var string
	 * @see \TYPO3\Flow\Mvc\Controller\RestController
	 */
	protected $resourceArgumentName = 'order';

	/**
	 * @Flow\Inject
	 * @var \Wwwision\Starbucks\Domain\Repository\OrderRepository
	 */
	protected $orderRepository;

	/**
	 * Lists all orders (this is invoked on empty GET requests)
	 *
	 * @return void
	 */
	public function listAction() {
		$this->view->assign('orders', $this->orderRepository->findAll());
	}

	/**
	 * Displays a single order (this is invoked on GET requests that specify the order to display)
	 *
	 * @param \Wwwision\Starbucks\Domain\Model\Order $order
	 * @return void
	 */
	public function showAction(Order $order) {
		$this->view->assign('order', $order);
	}

	/**
	 * By default Flow does not allow to create sub objects.
	 * Thus we have to explicitly allow creation of additions for the createAction()
	 *
	 * @return void
	 */
	public function initializeCreateAction() {
		parent::initializeCreateAction();
		$this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration()->forProperty('additions')->allowAllProperties();
	}

	/**
	 * Create a new order (this is invoked on POST requests)
	 *
	 * @param \Wwwision\Starbucks\Domain\Model\Order $order
	 * @return void
	 */
	public function createAction(Order $order) {
		$this->orderRepository->add($order);
		$this->persistenceManager->persistAll();
		$this->response->setStatus(201);
		$this->view->assign('order', $order);
	}

	/**
	 * Update an order (this is invoked on PUT requests)
	 *
	 * @param \Wwwision\Starbucks\Domain\Model\Order $order
	 * @return void
	 */
	public function updateAction(Order $order) {
		$this->orderRepository->update($order);
		$this->view->assign('order', $order);
	}

	/**
	 * Delete an order (this is invoked on DELETE requests)
	 *
	 * @param \Wwwision\Starbucks\Domain\Model\Order $order
	 * @return void
	 */
	public function deleteAction(Order $order) {
		$this->orderRepository->remove($order);
		$this->redirectToResource();
	}

	/**
	 * Detect the supported request methods for a single order and set the "Allow" header accordingly (This is invoked on OPTION requests)
	 *
	 * @return string An empty string in order to prevent the view from rendering the action
	 */
	public function resourceOptionsAction() {
		$allowedMethods = array('GET');
		$orderIdentifier = $this->request->getArgument('order');
		$order = $this->orderRepository->findByIdentifier($orderIdentifier);
		if ($order === NULL) {
			$this->throwStatus(404, NULL, 'The resource "' . $orderIdentifier . '" does not exist');
		}
		if (!$order->isPayed()) {
			$allowedMethods[] = 'PUT';
		}
		$this->response->setHeader('Allow', implode(', ', $allowedMethods));
		return '';
	}

}

?>