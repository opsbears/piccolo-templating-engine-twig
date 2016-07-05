<?php

namespace Piccolo\Templating\Engine\Twig;

/**
 * @covers Piccolo\Templating\Engine\Twig\TwigTemplateEngine
 */
class TwigTemplateEngineTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers Piccolo\Templating\Engine\Twig\TwigTemplateEngine::getExtension
	 */
	public function testExtension() {
		//setup
		$engine = new TwigTemplateEngine();
		//act
		//assert
		$this->assertEquals('twig', $engine->getExtension());
	}

	/**
	 * @covers Piccolo\Templating\Engine\Twig\TwigTemplateEngine::renderFile
	 */
	public function testRender() {
		//setup
		$engine = new TwigTemplateEngine();
		//act
		$content = $engine->renderFile(
			__DIR__ . '/../testdata',
			__DIR__ . '/../testdata/index.twig',
			['test' => 'Hello world!']
		);
		//assert
		$this->assertEquals('Hello world!', $content);
	}
}
