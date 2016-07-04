<?php

namespace Piccolo\Templating\Engine\Twig;

use Piccolo\Templating\TemplateEngine;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class TwigTemplateEngine implements TemplateEngine {
	public function getExtension() : string {
		return 'twig';
	}
	
	public function renderFile(string $templateRoot, string $fileName, array $data) : string {
		$loader = new Twig_Loader_Filesystem(realpath($templateRoot));
		$twig = new Twig_Environment($loader, array('debug' => true));
		$twig->addExtension(new Twig_Extension_Debug());

		return $twig->render(str_replace(realpath($templateRoot), '', realpath($fileName)), $data);
	}
}
