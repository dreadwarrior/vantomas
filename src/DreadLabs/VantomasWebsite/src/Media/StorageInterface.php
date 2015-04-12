<?php
namespace DreadLabs\VantomasWebsite\Media;

/**
 * A simple storage interface
 */
interface StorageInterface {

	/**
	 * Returns the public path of a media file
	 *
	 * "Public path" means: "From document root"
	 *
	 * @param Identifier $identifier
	 * @return string
	 */
	public function getPublicPath(Identifier $identifier);

}