<?php
namespace DreadLabs\VantomasWebsite\Media;

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