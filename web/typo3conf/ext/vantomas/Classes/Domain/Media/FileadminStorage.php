<?php
namespace DreadLabs\Vantomas\Domain\Media;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DreadLabs\VantomasWebsite\Media\Identifier;
use DreadLabs\VantomasWebsite\Media\StorageInterface;
use TYPO3\CMS\Core\Resource\ResourceStorageInterface;
use TYPO3\CMS\Core\Resource\StorageRepository;

/**
 * TYPO3 fileadmin/ storage impl
 */
class FileadminStorage implements StorageInterface {

	/**
	 * @var int
	 */
	private static $fileadminStorageId = 1;

	/**
	 * @var ResourceStorageInterface
	 */
	private $storage;

	/**
	 * @param StorageRepository $repository
	 * @return self
	 */
	public function __construct(
		StorageRepository $repository
	) {
		$this->storage = $repository->findByUid(self::$fileadminStorageId);
	}

	/**
	 * Returns the public path of a media file
	 *
	 * "Public path" means: "From document root" + "storage/start/folder/"
	 *
	 * @param Identifier $identifier
	 * @return string
	 */
	public function getPublicPath(Identifier $identifier) {
		$file = $this->storage->getFile($identifier->getValue());
		return $file->getPublicUrl();
	}
}