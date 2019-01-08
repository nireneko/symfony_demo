# Own Manager

## About the project:

This is just one project to learn Symfony, if is useful for someone, you're welcome :)

With this, I'm trying to lear about best practices in Symfony and test new ideas to improve my code on Drupal.

If you want a really good demo code of Symfony, you can get from their [official demo][1]: 

## Requirements:

* PHP 7.2 or higher
* MySQl 5.5 or higher

PHP 7.2 is required because this project use argon2i to encrypt the passwords.
You can change this in /config/packages/secutity.yaml and change the encrypt system to bcrypt.

## How use it:

Download it and execute:

```` bash
$ composer install
````

You need MySQL or MariaDB and configure the access on .env file, by default, the database name is "manager", the user "root" without password and the mysql port is 33067.
Configure the connection and run this commands:

```` bash
$ bin/console doctrine:database:create
$ bin/console doctrine:migrations:migrate
$ bin/console doctrine:fixtures:load
````
After this, you can test it on you web server, or use the server provided by Symfony:

```` bash
$ bin/console server:run
````

And access using http://127.0.0.1:8000, by default, the Symfony server is lisening in that port.

The default password of all users is "test".

## Please

Never think on this project like something stable or ready for production, this is just for testing and learn, and it can change in any moment.

## About author:

I'm Drupal developer who want learn Symfony in deep :)

My blog is [Nireneko][2], is about Drupal and in spanish.

[1]: https://github.com/symfony/demo
[2]: http://nireneko.com/