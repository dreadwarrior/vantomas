<?php
namespace DreadLabs\VantomasWebsite\Tests\Unit\Disqus;

class ConcreteResponseTest extends \PHPUnit_Framework_TestCase {

	protected $validContent = '';

	protected $invalidContent = '';

	public function setUp() {
		$this->validContent = file_get_contents(dirname(__FILE__) . '/../../Fixture/Disqus/ValidResponseContent.json');

		$this->invalidContent = file_get_contents(dirname(__FILE__) . '/../../Fixture/Disqus/InvalidResponseContent.json');
	}

	public function testContentReturnsAnInstanceOfStdClass() {
		$response = new \DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResponse();

		$response->setContent(json_decode($this->validContent));

		$content = $response->getContent();

		$this->assertInstanceOf('stdClass', $content, 'AbstractResponse::getContent() returns a stdClass instance.');
	}

	public function testContentThrowsAnExceptionIfResponseContainsAnError() {
		$this->setExpectedException(
			'DreadLabs\\VantomasWebsite\\Disqus\\Response\\Exception',
			'This is an example erroneous response message.'
		);

		$response = new \DreadLabs\VantomasWebsite\Tests\Fixture\Disqus\DummyResponse();

		$response->setContent(json_decode($this->invalidContent));

		$content = $response->getContent();
	}
}