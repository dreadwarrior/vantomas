<?php
namespace DreadLabs\VantomasWebsite\TeaserImage;

/**
 * The teaser image canvas
 */
interface CanvasInterface {

	/**
	 * @return void
	 */
	public function initialize();

	/**
	 * @param LayerInterface $layer
	 * @return void
	 */
	public function addLayer(LayerInterface $layer);

	/**
	 * @param string $alternativeText
	 * @return void
	 */
	public function setAlternativeText($alternativeText);

	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title);

	/**
	 * @return string
	 */
	public function render();
}