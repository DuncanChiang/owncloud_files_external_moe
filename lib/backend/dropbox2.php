<?php
/**
 * @author Duncan Chiang <duncan.c@inwinstack.com>
 * 
 * 
 * @copyright Copyright (c) 2016, inwinstack, Inc.
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
use \OCA\Files_External_MOE\Lib\LegacyDependencyCheckPolyfill;

use \OCA\Files_External_MOE\Lib\Auth\OAuth2\OAuth2;

class Dropbox2 extends Backend {

	use LegacyDependencyCheckPolyfill;

	public function __construct(IL10N $l, OAuth2 $legacyAuth) {
		$this
			->setIdentifier('dropbox2')
			->addIdentifierAlias('\OC\Files\Storage\Dropbox2') // legacy compat
			->setStorageClass('\OC\Files\Storage\Dropbox2')
			->setText($l->t('Dropbox'))
			->addAuthScheme(AuthMechanism::SCHEME_OAUTH2)
			->setLegacyAuthMechanism($legacyAuth)
		;
	}

}

