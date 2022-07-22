# Tweet Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 4.1.0.1 - 2022-07-22
### Fixed
- Fixed the Undefined array key if there aren't any urls or hashtags

## 4.1.0 - 2022-07-14
### Added
- Added a `| urlify` twig extension filter to parse all the urls and hashtags in a tweet

## 4.0.0 - 2022-05-03
### Changed
- Official Craft 4 Release

## 4.0.0.RC1 - 2022-05-02
### Changed
- Updated the Craft::parseEnv to App::parseEnv 
- Updated PHPDocs

### Fixed
- Fixed the service definition in `TweetFeed.php`

## 4.0.0-beta.1 - 2022-04-20
### Added
- Craft CMS 4 compatibility
- PHPStan Level 5
- Updated PHPDocs
- Updated Types

### Changed
- Improved settings getters in the services