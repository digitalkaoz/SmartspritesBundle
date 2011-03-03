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
    

Using DependencyInjection
-------------------------


::

    $this->get('smartsprites');    //returns the spriter


::

    #app/config/config.yml
    smartsprites:
      class:      rs\SmartspritesBundle\Util\Spriter
      input_dir:  %kernel.root_dir%/../web/css
      suffix:     -sprites
      output_dir: %kernel.root_dir%/../web/css
      files:      []
      


Using the Command
----------------

::

    # regenerate all sprites
    $ app/console assets:sprites
    

TODO
----

* more tests
* more sophisticated dic

