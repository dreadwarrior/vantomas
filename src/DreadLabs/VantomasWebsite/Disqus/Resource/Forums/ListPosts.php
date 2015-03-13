<?php
namespace DreadLabs\VantomasWebsite\Disqus\Resource\Forums;

use DreadLabs\VantomasWebsite\Disqus\Resource\AbstractResource;

class ListPosts extends AbstractResource {

	/**
	 * @var string
	 */
	protected $forum;

	/**
	 * @var int
	 */
	protected $since;

	/**
	 * @var array
	 */
	protected $related = array();

	/**
	 * @var mixed
	 */
	protected $cursor = null;

	/**
	 * @var int
	 */
	protected $limit = 25;

	/**
	 * @var string
	 */
	protected $query = '';

	/**
	 * @var array
	 */
	protected $include = array('approved');

	/**
	 * @var string
	 */
	protected $order = 'desc';

	/**
	 * @param string $forum
	 */
	public function setForum($forum) {
		$this->forum = $forum;
	}

	/**
	 * @param int $since
	 */
	public function setSince($since) {
		if (true === is_integer($since)) {
			$this->since = $since;
		}
	}

	/**
	 * @param array $related
	 */
	public function setRelated(array $related) {
		if (is_array($related) && 0 < count($related)) {
			$this->related = $related;
		}
	}

	/**
	 * @param mixed $cursor
	 */
	public function setCursor($cursor) {
		if (false === is_null($cursor)) {
			$this->cursor = $cursor;
		}
	}

	/**
	 * @param int $limit
	 */
	public function setLimit($limit) {
		if (is_numeric($limit)) {
			$this->limit = $limit;
		}
	}

	/**
	 * @param string $query
	 */
	public function setQuery($query) {
		if (false === is_null($query)) {
			$this->query = $query;
		}
	}

	/**
	 * @param array $include
	 */
	public function setInclude(array $include) {
		if (is_array($include) && 0 < count($include)) {
			$this->include = $include;
		}
	}

	/**
	 * @param string $order
	 */
	public function setOrder($order) {
		$this->order = $order;
	}
}