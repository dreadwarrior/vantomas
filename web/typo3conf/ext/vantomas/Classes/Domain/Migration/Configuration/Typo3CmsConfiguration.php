<?php
namespace DreadLabs\Vantomas\Domain\Migration\Configuration;

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

use Phinx\Config\ConfigInterface;

/**
 * Typo3CmsConfiguration
 *
 * A Phinx ConfigInterface implementation which directly plugs
 * into the TYPO3.CMS core to fetch the database connectivity
 * parameters.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class Typo3CmsConfiguration implements ConfigInterface {

	/**
	 * The environments (there is only one)
	 *
	 * @var array
	 */
	private $environments = array();

	/**
	 * Constructor
	 *
	 * @param array $configArray Config array
	 * @param string|null $configFilePath Optional file path
	 */
	public function __construct(array $configArray = array(), $configFilePath = NULL) {
		$this->environments = array(
			'default' => array(
				'adapter' => 'mysql',
				'host' => $GLOBALS['TYPO3_CONF_VARS']['DB']['host'],
				'name' => $GLOBALS['TYPO3_CONF_VARS']['DB']['database'],
				'user' => $GLOBALS['TYPO3_CONF_VARS']['DB']['username'],
				'pass' => $GLOBALS['TYPO3_CONF_VARS']['DB']['password'],
				'port' => $GLOBALS['TYPO3_CONF_VARS']['DB']['port'],
				'charset' => 'utf8',
			)
		);
	}

	/**
	 * Returns the configuration for each environment.
	 *
	 * This method returns <code>null</code> if no environments exist.
	 *
	 * @return array|null
	 */
	public function getEnvironments() {
		return $this->environments;
	}

	/**
	 * Returns the configuration for a given environment.
	 *
	 * This method returns <code>null</code> if the specified environment
	 * doesn't exist.
	 *
	 * @param string $name Environment name
	 *
	 * @return array|null
	 */
	public function getEnvironment($name) {
		return isset($this->environments[$name]) ? $this->environments[$name] : NULL;
	}

	/**
	 * Does the specified environment exist in the configuration file?
	 *
	 * @param string $name Environment name
	 *
	 * @return bool
	 */
	public function hasEnvironment($name) {
		return isset($this->environments[$name]);
	}

	/**
	 * Gets the default environment name.
	 *
	 * @return string
	 */
	public function getDefaultEnvironment() {
		return 'default';
	}

	/**
	 * Gets the config file path.
	 *
	 * @return string
	 */
	public function getConfigFilePath() {
		return PATH_site . '/../phinx.yml';
	}

	/**
	 * Gets the path of the migration files.
	 *
	 * @return string
	 */
	public function getMigrationPath() {
		return PATH_site . '/../migrations/';
	}

	/**
	 * Whether a offset exists
	 *
	 * The return value will be casted to boolean if non-boolean was returned.
	 *
	 * @param mixed $offset An offset to check for.
	 *
	 * @return bool True on success or false on failure.
	 */
	public function offsetExists($offset) {
		return isset($this->environments[0][$offset]);
	}

	/**
	 * Offset to retrieve
	 *
	 * @param mixed $offset The offset to retrieve.
	 *
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset) {
		return $this->environments[0][$offset];
	}

	/**
	 * Offset to set
	 *
	 * @param mixed $offset The offset to assign the value to.
	 * @param mixed $value The value to set.
	 *
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		$this->environments[0][$offset] = $value;
	}

	/**
	 * Offset to unset
	 *
	 * @param mixed $offset The offset to unset.
	 *
	 * @return void
	 */
	public function offsetUnset($offset) {
		unset($this->environments[0][$offset]);
	}
}
