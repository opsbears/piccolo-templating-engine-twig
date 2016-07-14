<?php

namespace Piccolo\Templating\Engine\Twig;

use Piccolo\Module\AbstractModule;
use Piccolo\Templating\TemplateEngine;
use Piccolo\DependencyInjection\DependencyInjectionContainer;
use Piccolo\Templating\TemplatingModule;

/**
 * This module registers the `TwigTemplateEngine` class as a template engine provider with the Templating module.
 * This can be used by invoking the `TemplateRenderingChain` class.
 *
 * @see https://github.com/opsbears/piccolo-templating
 *
 * @package Templating
 */
class TwigTemplatingModule extends AbstractModule {
	/**
	 * {@inheritdoc}
	 */
	public function getModuleKey() : string {
		return 'twig';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRequiredModules() : array {
		return [
			TemplatingModule::class
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function loadConfiguration(array &$moduleConfig, array &$globalConfig) {
		parent::loadConfiguration($moduleConfig, $globalConfig);

		$globalConfig['templating']['engines'][] = TwigTemplateEngine::class;
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureDependencyInjection(DependencyInjectionContainer $dic, array $moduleConfig,
												 array $globalConfig) {
		$dic->alias(TemplateEngine::class, TwigTemplateEngine::class);
	}
}
