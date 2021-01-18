<?php
namespace Slub\SlubForms\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Alexander Bigga <alexander.bigga@slub-dresden.de>, SLUB Dresden
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 *
 *
 * @package slub_forms
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmailRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

  /**
	 * Find all emails older than given days
	 *
	 * @param integer $days
	 * @return objects found old emails
	 */
	public function findOlderThan($days) {

    $query = $this->createQuery();

    $constraints = [];

    $constraints[] = $query->lessThanOrEqual('crdate', strtotime(' - ' . $days . ' days'));

    if (count($constraints)) {
        $query->matching($query->logicalAnd($constraints));
    }

    return $query->execute();

	}

  /**
	 * Delete all emails older than given days
	 *
	 * @param integer $days
	 * @return objects found old emails
	 */
	public function deleteOlderThan($days) {

	$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_slubforms_domain_model_email');
	$affectedRows = $queryBuilder->delete('tx_slubforms_domain_model_email')->where(
		$queryBuilder->expr()->lt('crdate', $queryBuilder->createNamedParameter(strtotime(' - ' . $days . ' days'), \PDO::PARAM_INT))
	)->execute();

    return true;

	}

}
