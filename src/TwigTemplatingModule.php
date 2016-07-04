<?php

namespace Piccolo\Templating\Engine\Twig;

use Piccolo\Module\AbstractModule;
use Piccolo\Templating\TemplateEngine;
use Piccolo\DependencyInjection\DependencyInjectionContainer;
use Piccolo\Templating\TemplatingModule;

class TwigTemplatingModule extends AbstractModule {
	public function getModuleKey() : string {
		return 'twig';
	}

	public function getRequiredModules() : array {
		return [
			TemplatingModule::class
		];
	}

	public function loadConfiguration(array &$moduleConfig, array &$globalConfig) {
		parent::loadConfiguration($moduleConfig, $globalConfig);

		$globalConfig['templating']['engines'][] = TwigTemplateEngine::class;
	}

	public function configureDependencyInjection(DependencyInjectionContainer $dic, array $moduleConfig,
												 array $globalConfig) {
		$dic->alias(TemplateEngine::class, TwigTemplateEngine::class);

		$dic->setClassParameters(TwigTemplateEngine::class, ['templateDirectory' => $moduleConfig['templateDirectory']]);
	}
}
