<?php

namespace Piccolo\Templating\Engine\Twig;

use Piccolo\Dev\DependencyInjectionContainerMock;
use Piccolo\Templating\TemplateEngine;
use Piccolo\Templating\TemplatingModule;

/**
 * @covers Piccolo\Templating\Engine\Twig\TwigTemplatingModule
 */
class TwigTemplatingModuleTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @covers Piccolo\Templating\Engine\Twig\TwigTemplatingModule::getModuleKey
	 */
	public function testGetModuleKey() {
		//setup
		$module = new TwigTemplatingModule();
		//act
		//assert
		$this->assertEquals('twig', $module->getModuleKey());
	}

	/**
	 * @covers Piccolo\Templating\Engine\Twig\TwigTemplatingModule::getRequiredModules
	 */
	public function testGetRequiredModules() {
		//setup
		$module = new TwigTemplatingModule();
		//act
		//assert
		$this->assertEquals([TemplatingModule::class], $module->getRequiredModules());
	}

	/**
	 * @covers Piccolo\Templating\Engine\Twig\TwigTemplatingModule::loadConfiguration
	 */
	public function testLoadConfiguration() {
		//setup
		$module = new TwigTemplatingModule();
		$globalConfiguration = [
			'templating' => [
				'engines' => [],
			],
			$module->getModuleKey() => [],
		];
		//act
		$module->loadConfiguration($globalConfiguration[$module->getModuleKey()], $globalConfiguration);
		//assert
		$this->assertEquals([TwigTemplateEngine::class], $globalConfiguration['templating']['engines']);
	}

	/**
	 * @covers Piccolo\Templating\Engine\Twig\TwigTemplatingModule::configureDependencyInjection
	 */
	public function testConfigureDependencyInjection() {
		//setup
		$module = new TwigTemplatingModule();
		$dic    = new DependencyInjectionContainerMock();
		$globalConfiguration = [
			'templating' => [
				'engines' => [TwigTemplateEngine::class],
			],
			$module->getModuleKey() => [],
		];
		//act
		$module->configureDependencyInjection(
			$dic,
			$globalConfiguration[$module->getModuleKey()],
			$globalConfiguration);
		//assert
		$this->assertEquals([TemplateEngine::class => TwigTemplateEngine::class], $dic->getAliases());
	}
}
