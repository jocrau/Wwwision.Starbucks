<?php
namespace Wwwision\Starbucks\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Wwwision.Starbucks".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\QueryInterface;

/**
 * @Flow\Scope("singleton")
 */
class DrinkRepository extends \TYPO3\Flow\Persistence\Repository {

	/**
	 * @var array
	 */
	protected $defaultOrderings = array('name' => QueryInterface::ORDER_ASCENDING);

}
?>