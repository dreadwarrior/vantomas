<?php
namespace DreadLabs\VantomasWebsite\TeaserImage;

interface TeaserImageInterface {

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

	public function render();
}