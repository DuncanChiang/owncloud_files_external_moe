<?php
/**
 * @author Robin McCorkell <rmccorkell@karoshi.org.uk>
 *
 * @copyright Copyright (c) 2015, ownCloud, Inc.
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\Files_External_MOE\Lib\Backend;

use \OCP\IL10N;
use \OCA\Files_External_MOE\Lib\Backend\Backend;
use \OCA\Files_External_MOE\Lib\DefinitionParameter;
use \OCA\Files_External_MOE\Lib\Auth\AuthMechanism;
use \OCA\Files_External_MOE\Service\BackendService;
use \OCA\Files_External_MOE\Lib\StorageConfig;
use \OCA\Files_External_MOE\Lib\LegacyDependencyCheckPolyfill;

use \OCA\Files_External_MOE\Lib\Auth\Password\Password;

class SMB extends Backend {

	use LegacyDependencyCheckPolyfill;

	public function __construct(IL10N $l, Password $legacyAuth) {
		$this
			->setIdentifier('smb')
			->addIdentifierAlias('\OC\Files\Storage\SMB') // legacy compat
			->setStorageClass('\OC\Files\Storage\SMB')
			->setText($l->t('SMB / CIFS'))
			->addParameters([
				(new DefinitionParameter('host', $l->t('Host'))),
				(new DefinitionParameter('share', $l->t('Share'))),
				(new DefinitionParameter('root', $l->t('Remote subfolder')))
					->setFlag(DefinitionParameter::FLAG_OPTIONAL),
				(new DefinitionParameter('domain', $l->t('Domain')))
					->setFlag(DefinitionParameter::FLAG_OPTIONAL),
			])
			->addAuthScheme(AuthMechanism::SCHEME_PASSWORD)
			->setLegacyAuthMechanism($legacyAuth)
		;
	}

	/**
	 * @param StorageConfig $storage
	 */
	public function manipulateStorageConfig(StorageConfig &$storage) {
		$user = $storage->getBackendOption('user');
		if ($domain = $storage->getBackendOption('domain')) {
			$storage->setBackendOption('user', $domain.'\\'.$user);
		}
	}

}