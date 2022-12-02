XML Data Importer [Symfony]
==================================

## Description
Xml data importer is a command-line program, based on the Symfony CLI component
(https://symfony.com/doc/current/components/console.html). The program is processing a
local or remote XML file and store the data in a CSV file. 

## Requirements

* PHP 8.1 or higher;
* Composer
* and the [Symfony application requirements][1].

or

* Docker

## Installation

You can setup the application in 2 ways:

1. Clone the application and execute these commands to install the project:

```bash
$ cd dataImporter/
$ composer install
$ php bin/console app:data-importer [filename]
```

2. You don't need to clone the application but instead pull the docker hub image:

For parsing external file:

```bash
$ docker pull scherbakovandrey/data-importer
$ touch ~/output.csv && docker run -v ~/output.csv:/usr/src/app/output.csv scherbakovandrey/data-importer php bin/console app:data-import https://www.somewebsite.com/feed.xml
 ```

For parsing local file:

```bash
$ docker pull scherbakovandrey/data-importer
$ touch ~/output.csv && docker run -v ~/feed.xml:/usr/src/app/feed.xml -v ~/output.csv:/usr/src/app/output.csv scherbakovandrey/data-importer php bin/console app:data-import /usr/src/app/feed.xml
 ```

## Tests

Execute these commands to run tests:

```bash
$ cd dataImporter/
$ php bin/phpunit
```
[1]: https://symfony.com/doc/current/reference/requirements.html