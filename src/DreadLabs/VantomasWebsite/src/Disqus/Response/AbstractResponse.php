<?php
namespace DreadLabs\VantomasWebsite\Disqus\Response;

abstract class AbstractResponse {

	/**
	 *
	 * @var \stdClass
	 */
	protected $content = null;

	/**
	 * sets the content property
	 *
	 * Implement the necessary logic of the specific response format here.
	 *
	 * @param string $content
	 * @return void
	 */
	abstract public function setContent($content);

	/**
	 * validates and returns the content property
	 *
	 * @return \stdClass
	 */
	final public function getContent() {
		$this->validateContent();

		return $this->content;
	}

	/**
	 * validates the content by checking if an error exists in the API response
	 *
	 * @return void
	 * @throws Exception if validation went wrong, e.g. an error was detected in the response
	 */
	final protected function validateContent() {
		if ($this->hasError()) {
			throw new Exception($this->getErrorMessage(), $this->getErrorCode());
		}
	}

	/**
	 * flags if the response contains an error property which is not 0
	 *
	 * @return boolean
	 */
	protected function hasError() {
		return $this->getErrorCode() !== 0;
	}

	/**
	 * returns the response error code
	 *
	 * @return integer
	 */
	protected function getErrorCode() {
		return is_object($this->content) && property_exists($this->content, 'code') ? (integer) $this->content->code : 0;
	}

	/**
	 * returns the response message if an error was in the response
	 *
	 * @return string
	 */
	protected function getErrorMessage() {
		return $this->hasError() ? $this->content->response : '';
	}
}