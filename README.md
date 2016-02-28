# (Unfinished) Web Application Framework
A tiny PHP web application framework.

I'm mostly doing this as an exercize in picking through some decisions other frameworks have made.

## Keeping it simple
I think that everyone has their own idea of simple, this is designed for a project that you want to be able to easily test with phpunit and dependency injection but isn't so large that you need to split your project into multiple packages within the project.  The idea is that if your project becomes that big you should probably use something like service oriented archetecture to split it up anyway.

## Design goals
* MVC style framework.
* Di/Configuration autocompletes in PhpStorm 10+
* PSR 2 compliant
* Di/Configuration both work the same way, and can be configured per environment.
* By default does not include any external libraries, I'll try to add examples for how to use twig for views.
* Easy to debug from end to end. I want to hit very little code before hitting the custom logic in the controller.
* Examples of how to use a persistance (database) and view, but nothing is included by default.
* A handful of common simple objects that you can optionally use (Session, Request, Response)

## Example flow when using this framework
An http POST happens: http://yoursite/account/save

Apache rewrite sends everything to http://yoursite/index.php behind the scenes with a path of /account/save

index.php calls the routing code that loads the controller account and calls the method saveAction.

The controller then makes sure the person is logged in and is who they say they are.

The controller then does data validaton to make sure everything being passed in is sane.

The controller then asks the dependency injection container for the AccountManager.  The dependency injector makes another call to create an AccountRepository that then requries and so creates a PDO connection to the database as a singleton. The AccountManager is returned with everything it needs.

The controller then uses the AccountManager to save the object.

The controller then returns a json encoded response indicating everything went well.

## Installation

## Write Something Small

## Unit Testing

