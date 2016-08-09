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
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function loadConfiguration(array &$moduleConfig, array &$globalConfig) {
		parent::loadConfiguration($moduleConfig, $globalConfig);
		if (!isset($globalConfig['templating']['engines'])) {
			$globalConfig['templating']['engines'] = [];
		}
		$globalConfig['templating']['engines'][] = TwigTemplateEngine::class;
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureDependencyInjection(DependencyInjectionContainer $dic, array $moduleConfig,
												 array $globalConfig) {
		$dic->alias(TemplateEngine::class, TwigTemplateEngine::class);

		if (!isset($moduleConfig['debug'])) {
			$moduleConfig['debug'] = false;
		}
		$dic->setClassParameters(TwigTemplateEngine::class, ['debug' => $moduleConfig['debug']]);
	}
}
