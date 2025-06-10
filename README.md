# Release Belt — Composer repo for ZIPs
[![Tests Status](https://github.com/atomicsmash/release-belt/actions/workflows/tests.yml/badge.svg)](https://github.com/atomicsmash/release-belt/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/atomicsmash/release-belt/version)](https://packagist.org/packages/atomicsmash/release-belt)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/atomicsmash/release-belt.svg)](https://packagist.org/packages/atomicsmash/release-belt)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat-square)](https://github.com/php-pds/skeleton)

Release Belt is a Composer repository, which serves to quickly integrate third–party non–Composer releases into Composer workflow. Once Release Belt is installed and you upload your zip files with their respective version number, Release Belt does the rest.

Given the following folder tree:

```
releases/wordpress-plugin/atomicsmash/plugin.1.0.zip
```

It will serve the following Composer repository at `/packages.json` automagically:

```json
{
    "packages": {
        "atomicsmash/plugin": {
            "1.0": {
                "name": "atomicsmash/plugin",
                "version": "1.0",
                "dist": {
                    "url": "http://example.com/atomicsmash/plugin.1.0.zip",
                    "type": "zip"
                },
                "type": "wordpress-plugin",
                "require": {
                    "composer/installers": "^1.5"
                }
            }
        }
    }
}
```

## Installation

### 1. Install the project

Release Belt is a `project` type Composer package. It is recommended to use Git checkout to keep up with updates more easily.

There is a helper Composer script provided that tries to fetch latest stable version and performs Composer install. 

#### Install

```bash
git clone https://github.com/atomicsmash/release-belt
cd release-belt
composer belt-update
```

#### Update

```bash
composer belt-update
```

### 2. Place release ZIPs into `releases/` directory

The directory structure should be: `releases/[type]/[vendor name]/[release zip file]`.

A `[type]` could be:
- a [native Composer type](https://getcomposer.org/doc/04-schema.md#type) (e.g. `library` for the default);
- any type [`composer/installers` supports](https://github.com/composer/installers) (e.g. `wordpress-plugin`);
- or completely arbitrary.

### 3. Configure a web server

The `public/` directory should be used as web root and `index.php` in it as the file to handle requests.

Please refer to [web server configuration](https://www.slimframework.com/docs/v4/start/web-servers.html) in Slim documentation and/or your web hosting’s resources for setup specifics.

Visit home page and `/packages.json` in a web browser to check if it is working.

## Use

Once Release Belt is installed you can add the repository to the `composer.json` of your projects.

Release Belt home page will automatically generate some `composer.json` boilerplate for you to use.

### Configuration

You can configure Release Belt by creating a `config/config.php` file, which returns an array of options to override.

See [`config/configExample.php`](config/configExample.php) for the annotated example.

#### Authentication & permissions

Release Belt implements HTTP authentication to password protect your repository and control access to specific packages. You can configure it via `users` configuration option.

There is a `bin/encodePassword.php` command line helper included for hashing passwords:

```bash
>php bin/encodePassword.php foo
$2y$10$3i9/lVd8UOFIJ6PAMFt8gu3/r5g0qeCJvoSlLCsvMTythye19F77a
```

If authentication is enabled, Release Belt home page will automatically generate `auth.json` boilerplate for you to use.

## F.A.Q.

### Why not Packagist/Satis?

Composer infrastructure is awesome, but it expects vendors that are willing to play nice with it.

Release Belt is a solution for unwilling vendors and it was faster and easier to build a dedicated solution from scratch. 

### Why not artifacts?

Composer artifacts require `composer.json` in them. This is for releases that don't even have that.

### But is it web scale?

No.

# License

MIT
