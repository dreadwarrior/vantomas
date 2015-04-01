<?php
namespace DreadLabs\Vantomas\Media;

use DreadLabs\VantomasWebsite\Media\Identifier;
use DreadLabs\VantomasWebsite\Media\StorageInterface;
use TYPO3\CMS\Core\Resource\ResourceStorageInterface;
use TYPO3\CMS\Core\Resource\StorageRepository;

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
	 * "Public path" means: "From document root"
	 *
	 * @param Identifier $identifier
	 * @return string
	 */
	public function getPublicPath(Identifier $identifier) {
		return $this->storage->getFile($identifier->getValue())->getPublicUrl();
	}
}