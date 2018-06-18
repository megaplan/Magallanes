# Magallanes
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ed0de53a-a12e-459b-9464-34def5907b56/mini.png)](https://insight.sensiolabs.com/projects/ed0de53a-a12e-459b-9464-34def5907b56)
[![Build Status](https://img.shields.io/travis/megaplan/Magallanes/master.svg)](https://travis-ci.org/megaplan/Magallanes)
[![Coverage Status](https://img.shields.io/coveralls/megaplan/Magallanes/master.svg)](https://coveralls.io/github/megaplan/Magallanes?branch=master)
[![Code Quality](https://img.shields.io/scrutinizer/g/megaplan/Magallanes.svg)](https://scrutinizer-ci.com/g/megaplan/Magallanes/)
[![Latest Stable Version](https://img.shields.io/packagist/v/megaplan/magallanes.svg?label=stable)](https://packagist.org/packages/megaplan/magallanes)
[![Pre Release](https://img.shields.io/packagist/vpre/megaplan/magallanes.svg?label=dev)](https://packagist.org/packages/megaplan/magallanes)
[![Total Downloads](https://img.shields.io/packagist/dt/megaplan/magallanes.svg)](https://packagist.org/packages/megaplan/magallanes)
[![License](https://img.shields.io/packagist/l/megaplan/magallanes.svg)](https://packagist.org/packages/megaplan/magallanes)

### What's Magallanes?
**Magallanes** is a deployment tool for made with PHP for PHP applications; it's quite simple to use and manage. For more information and documentation please visit http://magephp.com

### Installing
Simply add the following dependency to your project’s composer.json file:

```json
    "require": {
        "megaplan/magallanes": "^3.0"
    }
```
Finally you can use **Magallanes** from the vendor's bin:

```bash
$ vendor/bin/mage version
```

### Extra tasks

- `fs/shared: { link: app/config/parameters.yml [target: app/config/parameters.yml] }`

### What happend to version 2?
There is no version 2. I've skipped it and jumpped stright from v1 to v3. This new version of **Magallanes** is quite radical and different from it's successor. The whole application has been rewritten using **_Symfony3 Components_**, so naming it v3 makes a lot of sense.

### Codename Nostromo
Each new mayor version of **Magallanes** will have a codename (like Ubuntu), and in the current version it is **_Nostromo_**, like the spaceship from the movie *Alien (1979)*.
