<?php
namespace DreadLabs\Vantomas\Service\Disqus\Method\Forums;

class ListPosts extends \DreadLabs\Vantomas\Service\Disqus\Method\AbstractMethod {

	protected $forum;

	protected $since = NULL;

	protected $related = array();

	protected $cursor = NULL;

	protected $limit = 25;

	protected $query = NULL;

	protected $include = array('approved');

	protected $order = 'desc';

	public function setForum($forum) {
		$this->forum = $forum;
	}

	public function setSince($since) {
		if (TRUE === is_integer($since)) {
			$this->since = $since;
		}
	}

	public function setRelated($related) {
		if (is_array($related) && 0 < count($related)) {
			$this->related = $related;
		}
	}

	public function setCursor($cursor) {
		if (FALSE === is_null($cursor)) {
			$this->cursor = $cursor;
		}
	}

	public function setLimit($limit) {
		if (is_numeric($limit)) {
			$this->limit = $limit;
		}
	}

	public function setQuery($query) {
		if (FALSE === is_null($query)) {
			$this->query = $query;
		}
	}

	public function setInclude($include) {
		if (is_array($include) && 0 < count($include)) {
			$this->include = $include;
		}
	}

	public function setOrder($order) {
		$this->order = $order;
	}
}
?>