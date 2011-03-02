**Provides a symfony2 bundle for smartsprites**


Features
========

- see http://csssprites.org/ for usage

Installation
============

Add SmartspritesBundle to your *src/* dir
-------------

::

    $ git submodule add git://github.com/digitalkaoz/SmartspritesBundle.git src/rs/SmartspritesBundle
    $ git submodule init


Add the *rs* namespace to your autoloader
-------------

::

    // app/autoload.php

    $loader->registerNamespaces(array(
        'rs' => __DIR__.'/../src',
        // your other namespaces
    );


Add SmartspritesBundle to your application kernel
-------------


::

    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...
            new rs\SmartspritesBundle\SmartspritesBundle(),
            // ...
        );
    }
    
   //or use the BundleLoader (see below)
  

Using DependencyInjection
-------------------------


TODO
----

* more tests
* more sophisticated dic

