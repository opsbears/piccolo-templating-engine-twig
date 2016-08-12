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
	const CONFIG_DEBUG = 'debug';

	/**
	 * {@inheritdoc}
	 */
	public function getModuleKey() : string {
		return 'twig';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getModulesAfter() : array {
		return [
			TemplatingModule::class
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function loadConfiguration(array &$moduleConfig, array &$globalConfig) {
		/**
		 * @var TemplatingModule $templateModule
		 */
		$templateModule = $this->getRequiredModule(TemplatingModule::class);
		$templateModule->addTemplatingEngineClass($globalConfig, TwigTemplateEngine::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureDependencyInjection(DependencyInjectionContainer $dic, array $moduleConfig,
												 array $globalConfig) {
		$dic->alias(TemplateEngine::class, TwigTemplateEngine::class);

		if (!isset($moduleConfig[self::CONFIG_DEBUG])) {
			$moduleConfig[self::CONFIG_DEBUG] = false;
		}
		$dic->setClassParameters(TwigTemplateEngine::class, ['debug' => $moduleConfig[self::CONFIG_DEBUG]]);
	}
}
