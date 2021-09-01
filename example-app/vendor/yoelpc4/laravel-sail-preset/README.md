# Laravel Sail Preset

[![Packagist][ico-packagist]][link-packagist]
[![Downloads][ico-downloads]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Contributor Covenant][ico-code-of-conduct]](CODE_OF_CONDUCT.md)

_Laravel Sail runtimes & docker-compose.yml preset._

## Requirement

- [Laravel](https://laravel.com)
- [Laravel Sail](https://github.com/laravel/sail)

## Install

Require `laravel/sail` package with composer via command:

```shell
composer require laravel/sail --dev
```

Require this package with composer via command:

```shell
composer require yoelpc4/laravel-sail-preset --dev
```

## Package Publication

Publish `laravel/sail` preset via command:

```shell
php artisan sail:publish
```

Publish package preset via command:

```shell
php artisan sail:publish-preset
```

It'll replaces Dockerfile, php.ini, & docker-compose.yml according to the preset.

## Dependencies

- gnupg (Latest)
  
- gosu (Latest) 
  
- curl (Latest) 
  
- ca-certificates (Latest) 
  
- zip (Latest) 

- unzip (Latest) 
  
- git (Latest) 
  
- supervisor (Latest) 
  
- sqlite3 (Latest) 
  
- libcap2-bin (Latest)

- php

| Version | Extensions                                                                                                                                                                                                                                       |
|---------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 8.0     | - apcu<br>- bcmath<br>- curl<br>- imap<br>- gd<br>- igbinary<br>- imagick<br>- intl<br>- ldap<br>- mbstring<br>- msgpack<br>- mysql<br>- pgsql<br>- readline<br>- redis<br>- sqlite3<br>- soap<br>- xdebug<br>- xml<br>- yaml<br>- zip           |
| 7.4     | - apcu<br>- bcmath<br>- curl<br>- imap<br>- gd<br>- igbinary<br>- imagick<br>- intl<br>- ldap<br>- mbstring<br>- msgpack<br>- mysql<br>- pcov<br>- pgsql<br>- readline<br>- redis<br>- sqlite3<br>- soap<br>- xdebug<br>- xml<br>- yaml<br>- zip |

- composer (Latest)

- mysql-client (Latest)

- nodejs (LTS)

- yarn (Latest)

## License

The Laravel Sail Preset is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

[ico-packagist]: https://img.shields.io/packagist/v/yoelpc4/laravel-sail-preset.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/yoelpc4/laravel-sail-preset.svg?style=flat-square
[ico-license]: https://img.shields.io/packagist/l/yoelpc4/laravel-sail-preset.svg?style=flat-square
[ico-code-of-conduct]: https://img.shields.io/badge/Contributor%20Covenant-v2.0%20adopted-ff69b4.svg

[link-packagist]: https://packagist.org/packages/yoelpc4/laravel-sail-preset
