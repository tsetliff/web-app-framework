# Web Application Framework
A tiny PHP web application framework.

I had some issues with other frameworks, so this was just intended to be a demo of implemented solutions.  A few other people and I are each writing our own minimalist solution to building a simple web apps just for comparison.

## Keeping it simple
I think that everyone has their own idea of simple.  In reality simple tends to be what we know or what helps us acomplish our goals with as little work as possible.  In this case I want to accomplish the design goals under "what this framework has", so if you like those goals then this is the shortest path I could find to those features.

## What this framework has - Design goals
* MVC style framework.
* Dependency injection/Configuration autocompletes in PhpStorm 10+
* PSR-2 compliant
* Per environment configuration.
* PHP 6.4 and PHP 7 compatible.
* Easy to debug from end to end. I want to hit very little code from the request to the custom logic in the controller.
* A handful of common simple objects that you can optionally use, I'll decide as I go.
* REST verbs route.

## What this framework does not have
* Dependencies outside of core PHP.
* Configuration file parsing.
* "Magic" as that really just means "Have fun figuring out what I did".  Assuming you have done some PHP I want you to easily understand what your debugger walks through, no magic.  If you don't understand something feel free to send me a message.
* No internal package system though you can add composer. The idea is that if your project becomes that big you should probably use something like service oriented architecture to split it up anyway. You can however easily pull in libraries with composer.
* A bunch of other stuff that is common to frameworks, I did this as a quick side project but if you write something extremely light weight I'll consider a pull request.  I may also add additional objects as I feel that I need to.


## Example flow when using this framework
An http POST happens: http://yoursite/Account/save

Apache rewrite sends everything to http://yoursite/index.php behind the scenes with a path of /Account/save

index.php calls the routing code that loads the controller Account and calls the method saveAction.

The controller then makes sure the person is logged in and is who they say they are.

The controller then does data validaton to make sure everything being passed in is sane.

The controller then asks the dependency injection container for the AccountManager.  The dependency injector makes another call to create an AccountRepository that then requries and so creates a PDO connection to the database as a singleton. The AccountManager is returned with everything it needs.

The controller then uses the AccountManager to save the object.

The controller then returns a json encoded response indicating everything went well.

## Changes to above flow when using REST
An http PUT happens to : http://yoursite/Account/12345

The router sees that rest is enabled on the Account controller at Account->rest and calls the Account/putAction method.

The put method then ensures that the person is logged in, validates the data, gets the repository and updates the object in the repository, and returns an affermative response.

## Install/Create a project
Setup your environment for developing in.  I've installed Centos 7 in a VM.

Install php 6.4+ or php 7 (Unless you want to be brave and test something I haven't) feel free to install your persistance mechanism, I'm also installing mysql and mysql-server.

Since this project is designed to take advantage of autocomplete, you might as well use a modern IDE.  I'm going to do this in PHPStorm 10 and give the instructions for getting up and running in that IDE.

Create a new empty project.

Copy the contents of the template directory in this project into phpstorm, so you have an app and public_html directory in your root directory.

Init a git repository, you don't want to loose your work.

Add everything to the git repository and create an initial commit.

I set the mappings up in PHPStorm so that the app directory in the project mapped to /var/www/app and the public_html directory mapped to /var/www/html since that's all this server is for and this will create fewer apache configuration changes, feel free to chamge mappings to suit.

In PHPStorm I set the new server as the default and set the autoload option on the deployment menu.

Check to make sure the files ended up on your test VM where you expected them to be.

Rename the directory src/YourName/YourProject to be your name or your organizations name for your namespace root followed by the name of this project.  This may feel like a lot of directories but it keeps it PSR-0 complient for when you want to package your project or use it with another PSR-0 compliant autoloader.

Then replace all the instances of YourName/YourProject in the template with the new values... what can I say the result won't have any magic since these are the example classes for you to edit, not something in the framework namespace.

Edit the configuration options in public_html/config.php to match where you put everything.

You should have a working hello world example.

## How does this DI system work?
So the idea is you set up all of the different things you need to inject in your own Di class that extends DiBase that is included with the framework. You then create one additional class to extend that class for each environment such as Dev/Prod/Testing.
Then you set your environment in the config.php file.

In your Dev environment the system creates an instance of your DiDev class, and sets it as a singleton on the DiBase object.  Throughout your project when you say Di::instance()->getWhateverComponent() you are actually calling DiDev so that it can optionally override any of your methods in your Di class but autocomplete still works fine because everything is declared in your Di class.

A common example is that you want a database PDO object that you can use in your widget repository.  So in your Di class you create the method:
```
public function getDatabaseConnection()
{
  new PDO...
}
public function getWidgetRepository()
{
  new WidgetRepository($this->getDatabaseConnection());
}
```

By passing the database connection into your widget repository instead of creating an instance in the repository you are free to pack a mock connection in when writing tests so that repository tests don't need to access your database.

In your controller you then just have something like this:
```
class WidgetController
{
  public function getAction()
  {
    $widgetId = $this->request->getRestParameter(0);
    // Place any verification of widget ID and session permissions here.
    $widget = Di::instance()->getWidgetRepository()->getWidget($widgetId);
    return $this->response->returnJson($widget->toArray());
  }
}
```

## How does the configuraton system work?
It works almost exactly like the DI system but uses properties instead of methods.  If you want to confgure something more complicated you can use methods as well just like the DI system.

If you want to have super secret stuff in your production file just check if the production file exists somewhere else with ConfigProd in it and load it. Once loaded the autoloader won't load the default ConfigProd.php file.

But can't this be done with a single file with switch statements in it?  I couldn't find a way that would autocomplete (associative array is out), be global without saying global everywhere (again associative array is out), be overridden by different environments(defines were out), not require external file parsing (.ini files were out but then again they have the other issues too).  So in the end I decided this worked the best.  If you can figure this out please let me know.


## Unit Testing
In general you just put tests in the testing directory with the same structure as the classes you are testing in the classes directory.  The environment is Testing and so the associated configuration and dependency injection classes will be loaded.

## But I want to use composer
Just init composer in the app directory, You can uncomment the line in app/autoloader.php that points to composers autoloader.

