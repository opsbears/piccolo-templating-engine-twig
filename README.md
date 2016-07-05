# Twig module for Piccolo Templating [![Build Status](https://travis-ci.org/opsbears/piccolo-templating-engine-twig.svg?branch=master)](https://travis-ci.org/opsbears/piccolo-templating-engine-twig)

This module provides templating for Piccolo using the [Twig template engine](http://twig.sensiolabs.org/).

## Installation

This module can be installed using composer:

```
composer require opsbears/piccolo-templating-engine-twig
```

## Usage

There are two ways of using this template engine.

## Using Twig directly

The `TwigTemplateEngine` class implements the `TemplateEngine` interface, so you can use it directly by registering 
it in your dependency injection container as an alias. (This is done automatically if you load the 
`TwigTemplatingModule`.) You can then use it to render a template:

```
function myFunction(TemplateEngine $tpl) {
    $tpl->renderFile(
        '/path/to/template/directory',
        '/path/to/template/directory/templateName.twig'
        ['myVariable' => 'mydata]
    );
}
```

## Using the rendering chain

The [Piccolo Templating module](https://github.com/opsbears/piccolo-templating) provides a way to register multiple 
template engines and look for a template with multiple extensions. So you could run Twig and Smarty in parallel for 
example.

In order to do that, you will need to register the TwigTemplatingModule with your application:

```
'modules' => [
    TwigTemplatingModule::class
]
```

This will register the TwigTemplateEngine as a supported template engine with the Templating module. It can then be 
used with the `TemplateRenderingChain` class with automatic dependency injection:

```
function myFunction(TemplateRenderingChain $renderingChain) {
    $renderingChain->render(
        '/path/to/template/directory',
        'templateName'
        ['myVariable' => 'mydata]
    );
}
```
