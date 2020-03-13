# Sakila-lumen

CRUD API for the MySql "Sakila" database schema build with Lumen micro-framework by Laravel, domain logic based in separate project `piobuddev/sakila`

## Development setup:
### Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
* PHP >= `7.1`
* [Composer](https://getcomposer.org/): tool for dependency management in PHP

### Installing

To get the development environment running clone the repository and run the composer

```sh
$ git clone git@github.com:piobuddev/sakila-lumen.git
$ cd sakila-lumen/
$ cp .env.example .env
$ composer install
```

```sh
$ echo `127.0.0.1    sakila-lumen.local`
```

Update `.env` and `.env_testing` with DB connection details

Swagger documentation available at `https://sakila-lumen.local/docs`

## Running the tests

### Coding style tests
##### PHPStan : PHP Static Analysis Tool

```sh
$ vendor/bin/phpstan analyse -l 7 src tests -c phpstan.neon
```
##### PHPCS : Detects violations of a defined set of coding standards

```sh
$ vendor/bin/phpcs --standard=PSR2 --extensions=php --colors --severity=1 src
```

##### PHPUNIT and BEHAT
```sh
$ vendor\bin\phpunit --no-coverage
$ vendor\bin\behat --colors
```

or run all tests together with:
```sh
$ composer test
```

Additionaly you can fix code formatting with:
##### PHPCBF : PHP Code Beautifier and Fixer

```sh
$ vendor/bin/phpcbf --standard=PSR2 --extensions=php --colors --severity=1 src
```

## Built With
* [Lumen](https://lumen.laravel.com/) The stunningly fast micro-framework by Laravel
* [Fractal](https://fractal.thephpleague.com/) - A presentation and transformation layer for complex data output
* [piobuddev/sakila](https://github.com/piobuddev/sakila) - Domain logic
* [piobuddev/repository-tester](https://github.com/piobuddev/repository-tester) - Helper that provides a simple api to create a fake data and perform a database operations.
* [piobuddev/behat-webapi-extension](https://github.com/piobuddev/behat-webapi-extension) -  Web Api extension for Behat helps with performing http requests and interacting with a database.


## Code Style
* [PSR2](https://www.php-fig.org/psr/psr-2/)

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/piobuddev/c04b7341f68da9718907cb593012d746) for details on my code of conduct, and the process for submitting pull requests to me.

## Versioning

I use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/piobuddev/behat-webapi-extension/tags). 

## Authors

* **Piotr Budny** - [piobuddev](https://github.com/piobuddev)

## License

This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/piobuddev/repository-tester/blob/master/LICENSE.md) file for details
