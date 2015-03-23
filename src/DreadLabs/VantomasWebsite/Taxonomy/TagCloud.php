<?php
namespace DreadLabs\VantomasWebsite\Taxonomy;

use DreadLabs\VantomasWebsite\Page\Tag;
use Traversable;

class TagCloud implements TagCloudInterface {

	/**
	 * @var array
	 */
	private $tags;

	/**
	 * @var \Arg\Tagcloud\Tagcloud
	 */
	private $tagCloud;

	/**
	 * @param \Arg\Tagcloud\Tagcloud $tagCloud
	 */
	public function __construct(\Arg\Tagcloud\Tagcloud $tagCloud) {
		$this->tagCloud = $tagCloud;
		$this->tagCloud->setOrder('size', 'DESC');
		$this->tagCloud->setLimit(25);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 */
	public function getIterator() {
		return new \ArrayIterator($this->toArray());
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset) {
		return isset($this->tags[$offset]);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset) {
		return $this->tags[$offset];
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		if (!isset($offset)) {
			$this->tags[] = $value;
		} else {
			$this->tags[$offset] = $value;
		}
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param Tag $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset($offset) {
		$this->tags = array_filter($this->tags, function ($v) use ($offset) {
			return $v !== $offset->getValue();
		});
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 */
	public function count() {
		return count($this->tags);
	}

	/**
	 * @param Tag $tag
	 * @return void
	 */
	public function add(Tag $tag) {
		$this->offsetSet(null, $tag->getValue());
	}

	/**
	 * @param Tag $tag
	 * @return void
	 */
	public function remove(Tag $tag) {
		$this->offsetUnset($tag);
	}

	/**
	 * @return Tag[]
	 */
	public function toArray() {
		$tags = array();

		$this->tagCloud->addTags($this->tags);
		$_tags = $this->tagCloud->render('array');
		foreach ($_tags as $tagAttributes) {
			$tags[] = Tag::fromString($tagAttributes['tag']);
		}
		return $tags;
	}
}