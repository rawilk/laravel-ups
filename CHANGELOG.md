# Changelog

All notable changes to `laravel-ups` will be documented in this file

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
