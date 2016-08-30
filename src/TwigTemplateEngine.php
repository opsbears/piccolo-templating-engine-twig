<?php

namespace Piccolo\Templating\Engine\Twig;

use Piccolo\Templating\TemplateEngine;
use Piccolo\Templating\TemplateFilter;
use Piccolo\Templating\TemplateFunction;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Extensions_Extension_Array;
use Twig_Extensions_Extension_Date;
use Twig_Extensions_Extension_Intl;
use Twig_Extensions_Extension_Text;
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
	 * @var TemplateFilter[]
	 */
	private $filters = [];

	/**
	 * @var TemplateFunction[]
	 */
	private $functions = [];

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
	public function renderFile(
		string $templateRoot,
		string $fileName,
		array $data,
		array $templateRoots = []
	) : string {
		$loader = new Twig_Loader_Filesystem(\realpath($templateRoot));

		foreach ($templateRoots as $templateRootName => $templateRootDirectory) {
			$loader->addPath($templateRootDirectory, $templateRootName);
		}

		$twig   = new Twig_Environment($loader, ['debug' => $this->debug]);

		$twig->addExtension(new Twig_Extension_Debug());
		$twig->addExtension(new Twig_Extensions_Extension_Text());
		$twig->addExtension(new Twig_Extensions_Extension_Array());
		$twig->addExtension(new Twig_Extensions_Extension_Date());
		if (\class_exists('IntlDateFormatter')) {
			$twig->addExtension(new Twig_Extensions_Extension_Intl());
		}

		foreach ($this->filters as $filter) {
			$twig->addFilter(new \Twig_SimpleFilter($filter->getName(), array($filter, 'filter')));
		}
		foreach ($this->functions as $function) {
			$twig->addFunction(new \Twig_SimpleFunction($function->getName(), array($function, 'execute')));
		}

		$data['twig'] = ['debug' => $this->debug];

		return $twig->render(\str_replace(\realpath($templateRoot), '', \realpath($fileName)), $data);
	}

	/**
	 * @param TemplateFilter $filter
	 */
	public function registerFilter(TemplateFilter $filter) {
		$this->filters[] = $filter;
	}

	/**
	 * @param TemplateFunction $function
	 */
	public function registerFunction(TemplateFunction $function) {
		$this->functions[] = $function;
	}
}
