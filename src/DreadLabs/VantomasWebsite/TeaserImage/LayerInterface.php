<?php
namespace DreadLabs\VantomasWebsite\TeaserImage;

interface LayerInterface {

	public function setWidth($width);

	public function setHeight($height);

	public function setMinimumWidth($minimumWidth);

	public function setOffset(Offset $offset);

}