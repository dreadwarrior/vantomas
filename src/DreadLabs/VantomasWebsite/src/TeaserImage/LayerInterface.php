<?php
namespace DreadLabs\VantomasWebsite\TeaserImage;

/**
 * A teaser image layer
 */
interface LayerInterface {

	/**
	 * @param mixed $width
	 * @return void
	 */
	public function setWidth($width);

	/**
	 * @param mixed $height
	 * @return void
	 */
	public function setHeight($height);

	/**
	 * @param mixed $minimumWidth
	 * @return void
	 */
	public function setMinimumWidth($minimumWidth);

	/**
	 * @param Offset $offset
	 * @return void
	 */
	public function setOffset(Offset $offset);

	/**
	 * Provides an array representation of the layer
	 *
	 * @return array
	 */
	public function toArray();

}