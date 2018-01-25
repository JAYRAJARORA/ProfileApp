Profile App
========================

Welcome to the Profile App which is developed in Symfony 2.8.

What's inside?
--------------

The Profile App is configured with the following defaults:
````
An AppBundle you can use to start coding;
Twig as the only configured template engine;
Doctrine ORM/DBAL;
Swiftmailer;
Annotations enabled for everything.
````
It comes pre-configured with the following bundles:

* **FrameworkBundle** - The core Symfony framework bundle
* **SensioFrameworkExtraBundle** - Adds several enhancements, including
    template and routing annotation capability
* **DoctrineBundle** - Adds support for the Doctrine ORM
* **TwigBundle** - Adds support for the Twig templating engine
* **SecurityBundle** - Adds security by integrating Symfony's security
    component
* **SwiftmailerBundle** - Adds support for Swiftmailer, a library for
    sending emails

It contains the following bundle:

* **UserBundle** - It contains the following items:
    * Controllers : The controller contains action for particular routes.They are:
        * HomeController - for home page and update profile page.
        * RegisterController - for register page.
        * SecurityController - for providing authentication to users and allowing reset password feature
        * TwiiterController - to retrieve the tweets of the user using TwitterOauth
    
    * Model/Entity : User Entity which maps the fields in class to columns in dB.
    
    * View/Twig : It contains views which are rendered according to the particular action in controller.They are:
        * Home - Update and home page views
        * Register - Register page with fields needed.
        * Security - Login Page, Reset password page and email to be sent to the user.
        * Twitter -  Tweets to be displayed
        * Header - Extending base twig which contains overall layoout of the page.
    
Installation
--------------   

For Installing symfony 2.8 and the necessary bundles use composer.

* Composer Installation: curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
* Symfony Installation:  composer create-project symfony/framework-standard-edition:2.8.32 NameOfProject
* Doctrine Fixtures Bundle: composer require doctrine/doctrine-fixtures-bundle:2.3.0
* Doctrine Migrations Bundle: composer require doctrine/doctrine-migrations-bundle:1.3.1
* Twitter Bundle: composer require abraham/twitteroauth:^0.7.4
 

