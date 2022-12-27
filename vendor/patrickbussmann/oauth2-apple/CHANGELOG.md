# Changelog
All Notable changes to `oauth2-apple` will be documented in this file

## 0.3.0 - 202X-XX-XX

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.2.10 - 2022-10-01

### Added
- "sub" to Resource Owner->toArray() [#38](https://github.com/patrickbussmann/oauth2-apple/pull/38)
- Apple Key retrieval when using Guzzle Logging [#39](https://github.com/patrickbussmann/oauth2-apple/pull/39)

## 0.2.9 - 2022-07-09

### Added
- Method for revoking access and refresh tokens [#37](https://github.com/patrickbussmann/oauth2-apple/issues/37)

## 0.2.8 - 2022-05-10

### Fixed
- Issue with firebase/php-jwt v5 [#34](https://github.com/patrickbussmann/oauth2-apple/issues/34) (thanks to [tjveldhuizen](https://github.com/tjveldhuizen))

## 0.2.7 - 2022-04-29

### Added
- Support for firebase/php-jwt v6 [#31](https://github.com/patrickbussmann/oauth2-apple/pull/31) (thanks to [bashgeek](https://github.com/bashgeek))

## 0.2.6 - 2021-08-25

### Added
- GitHub Actions CI

### Removed
- Travis CI

### Fixed
- Fixed bug with serialization of AppleAccessToken [#29](https://github.com/patrickbussmann/oauth2-apple/pull/29) (thanks to [tjveldhuizen](https://github.com/tjveldhuizen))

## 0.2.5 - 2021-03-10

### Fixed
- Fix BC-break for combination of PHP 7.4 and lcobucci/jwt 3.4 [#25](https://github.com/patrickbussmann/oauth2-apple/pull/25) (thanks to [tjveldhuizen](https://github.com/tjveldhuizen))

## 0.2.4 - 2021-01-17

### Added
- Codecov for Code Coverage

### Fixed
- Few compatibility issues with PHP 8 and PHP 5.6 (Read [#16](https://github.com/patrickbussmann/oauth2-apple/pull/16) for more details)

## 0.2.3 - 2021-01-05

### Added
- Using guzzle http instead of file_get_contents [#14](https://github.com/patrickbussmann/oauth2-apple/pull/14)/[#17](https://github.com/patrickbussmann/oauth2-apple/pull/17) (thanks to [jmalinens](https://github.com/jmalinens) and [williamxsp](https://github.com/williamxsp))
- README no scope instruction [#15](https://github.com/patrickbussmann/oauth2-apple/pull/15) (thanks to [NgSekLong](https://github.com/NgSekLong))
- README leeway usage [#18](https://github.com/patrickbussmann/oauth2-apple/issues/18) (thanks to [lukequinnell](https://github.com/lukequinnell))

### Fixed
- Fixed getting first and last name issues [#13](https://github.com/patrickbussmann/oauth2-apple/pull/13) (thanks to [bogdandovgopol](https://github.com/bogdandovgopol))

## 0.2.1 - 2020-02-13

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Handling of Apples JSON Web Key Set
- Undefined index: code [#4](https://github.com/patrickbussmann/oauth2-apple/pull/4) (thanks to [Darlinkster](https://github.com/Darlinkster))

### Removed
- Nothing

### Security
- Nothing

## 0.2.0 - 2019-10-31

### Added
- PHP 5.6 compatibility
- More test cases

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 0.1.0 - 2019-10-18

### Added
- Initial release!

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing
