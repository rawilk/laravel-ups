# Changelog

All notable changes to `laravel-ups` will be documented in this file

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
