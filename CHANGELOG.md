# Changelog

All notable changes to `laravel-ups` will be documented in this file

## v2.1.7 - 2025-03-18

### What's Changed

* Bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/rawilk/laravel-ups/pull/21
* Bump dependabot/fetch-metadata from 1.4.0 to 1.5.0 by @dependabot in https://github.com/rawilk/laravel-ups/pull/22
* Bump dependabot/fetch-metadata from 1.5.0 to 1.5.1 by @dependabot in https://github.com/rawilk/laravel-ups/pull/24
* Bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/rawilk/laravel-ups/pull/29
* Bump dependabot/fetch-metadata from 1.6.0 to 2.1.0 by @dependabot in https://github.com/rawilk/laravel-ups/pull/39
* Laravel 11/12.x support

**Full Changelog**: https://github.com/rawilk/laravel-ups/compare/v2.1.6...v2.1.7

## v2.1.6 - 2023-03-20

### What's Changed

- Bump dependabot/fetch-metadata from 1.3.4 to 1.3.5 by @dependabot in https://github.com/rawilk/laravel-ups/pull/10
- Bump dependabot/fetch-metadata from 1.3.5 to 1.3.6 by @dependabot in https://github.com/rawilk/laravel-ups/pull/13
- Bump creyD/prettier_action from 4.2 to 4.3 by @dependabot in https://github.com/rawilk/laravel-ups/pull/14
- Add laravel 10.x support by @rawilk in https://github.com/rawilk/laravel-ups/pull/16
- Add php 8.2 support by @rawilk in https://github.com/rawilk/laravel-ups/pull/17

**Full Changelog**: https://github.com/rawilk/laravel-ups/compare/v2.1.5...v2.1.6

## v2.1.5 - 2022-11-03

### What's Changed

- Bump creyD/prettier_action from 3.0 to 4.2 by @dependabot in https://github.com/rawilk/laravel-ups/pull/7
- Bump actions/checkout from 2 to 3 by @dependabot in https://github.com/rawilk/laravel-ups/pull/8
- Convert test suite to pest
- Use `spatie/laravel-package-tools` for service provider

**Full Changelog**: https://github.com/rawilk/laravel-ups/compare/v2.1.4...v2.1.5

## v2.1.4 - 2022-06-28

### Updated

- Store shipping labels in GIF format instead of PNG
- Use `imagerotate` instead of `Imagick` to rotate shipping labels

## 2.1.3 - 2022-02-22

### Updated

- Add Laravel 9.* support - [#3](https://github.com/rawilk/laravel-ups/issues/3)
- Add PHP 8.1 support

### Fixed

- Make any `offsetGet()` calls compatible with ArrayAccess interface

## 2.1.2 - 2021-08-18

### Fixed

- Encode special characters with `htmlspecialchars` when converting entities to xml

## 2.1.1 - 2021-03-04

### Updated

- Update `ShipAcceptResponse` to set negotiated rates
- Stop `ShipAcceptResponse` from filtering out $0.00 charges

## 2.1.0 - 2021-03-04

### Added

- Add ability to store generated label images automatically ([#1](https://github.com/rawilk/laravel-ups/issues/1))
- Add ability to retrieve decoded label images instead of decoding them manually ([#1](https://github.com/rawilk/laravel-ups/issues/1))
- Add configuration option to automatically rotate generated shipping label images vertically ([#1](https://github.com/rawilk/laravel-ups/issues/1))

## 2.0.0 - 2021-02-22

### Breaking Changes

- Drop support for PHP 7
- Drop support for Laravel 7
- Require PHP 8

## 1.0.0 - 2020-09-25

- initial release
