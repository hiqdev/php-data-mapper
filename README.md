# Data Mapper

**Data Mapper**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/php-data-mapper/v/stable)](https://packagist.org/packages/hiqdev/php-data-mapper)
[![Total Downloads](https://poser.pugx.org/hiqdev/php-data-mapper/downloads)](https://packagist.org/packages/hiqdev/php-data-mapper)
[![Build Status](https://img.shields.io/travis/hiqdev/php-data-mapper.svg)](https://travis-ci.org/hiqdev/php-data-mapper)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hiqdev/php-data-mapper.svg)](https://scrutinizer-ci.com/g/hiqdev/php-data-mapper/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/hiqdev/php-data-mapper.svg)](https://scrutinizer-ci.com/g/hiqdev/php-data-mapper/)
[![Dependency Status](https://www.versioneye.com/php/hiqdev:php-data-mapper/dev-master/badge.svg)](https://www.versioneye.com/php/hiqdev:php-data-mapper/dev-master)

[Data Mapper] based on Yii2 data base abstraction.

Deliberately simple (no implicit behavior) library aimed to separate data persistence logics from data own logics.

## Idea

 Abstraction    | Implementation                           | Examples
----------------|------------------------------------------|--------------------------------------
Domain Layer    | Entity, RepositoryInterface              | Customer, CustomerRepositoryInterface
Data Mapper 1   | Hydration, Attribution, Specification    | CustomerHydrator, CustomerAttribution
Data Mapper 2   | Repository, Query,                       | CustomerRepository, CustomerQuery
Data Access     | Query, QueryBuilder                      | PDO, ActiveRecord, HiArt
DATA            | Storage                                  | DB, API, Queue, File System

[Data Mapper]: https://en.wikipedia.org/wiki/Data_mapper_pattern

## Installation

The preferred way to install this package is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require "hiqdev/php-data-mapper"
```

or add

```json
"hiqdev/php-data-mapper": "*"
```

to the require section of your composer.json.

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2017-2018, HiQDev (http://hiqdev.com/)
