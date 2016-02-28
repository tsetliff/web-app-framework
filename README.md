# Web Application Framework
A tiny PHP web application framework

I'm mostly doing this as an exercize in picking through some decisions other frameworks have made.

## Keeping it simple
I think that everyone has their own idea of simple, this is designed for a project that you want to be able to easily test with phpunit and dependency injection but isn't so large that you need to split your project into multiple packages within the project.  The idea is that if your project becomes that big you should probably use something like service oriented archetecture to split it up anyway.

## Design goals
* Di/Configuration autocompletes in PhpStorm 10+
* Di/Configuration both work the same way, and can be configured per environment.
* By default does not include any external libraries, I'll try to add examples for how to use twig for views.
* Easy to debug from end to end. I want to hit very little code before hitting the custom logic in the controller.
