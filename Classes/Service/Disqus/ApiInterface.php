<?php
namespace DreadLabs\Vantomas\Service\Disqus;

use \TYPO3\CMS\Core\SingletonInterface;

interface ApiInterface extends SingletonInterface {

	public function getData($url);

	public function loadData($url);
}
?>