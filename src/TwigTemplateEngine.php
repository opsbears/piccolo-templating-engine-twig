<?php

namespace Piccolo\Templating\Engine\Twig;

use Piccolo\Templating\TemplateEngine;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

/**
 * This class is a template engine provider that utilizes the Twig template engine to render templates.
 *
 * @see http://twig.sensiolabs.org/
 *
 * @package Templating
 */
class TwigTemplateEngine implements TemplateEngine {
	/**
	 * @var bool
	 */
	private $debug;

	/**
	 * @param bool $debug
	 */
	public function __construct(bool $debug) {
		$this->debug = $debug;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtension() : string {
		return 'twig';
	}

	/**
	 * {@inheritdoc}
	 */
	public function renderFile(string $templateRoot, string $fileName, array $data) : string {
		$loader = new Twig_Loader_Filesystem(\realpath($templateRoot));
		$twig   = new Twig_Environment($loader, ['debug' => $this->debug]);
		$twig->addExtension(new Twig_Extension_Debug());

		$data['twig'] = ['debug' => $this->debug];

		return $twig->render(\str_replace(\realpath($templateRoot), '', \realpath($fileName)), $data);
	}
}
