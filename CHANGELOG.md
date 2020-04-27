# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2020-04-25
### Added

- DataTablesCryptoManger to encrypt and decrypt entity name passed by POST
- ListingManager service to improve ListingBuilder creation
- ListingInvalidArgumentException to force usage one of the two methods annotation/encryption

### Changed

- Mark deprecated methods and annotation class
- DataTablesController to handle annotation and "encrypted entity" method
- Listing tests to check if new solution and deprecated are still valid 

## [1.0.0] - 2020-02-26
### Added

- Annotation DataTables class, to handle entity and search field
- Listing related classes
- ListingBuilder, with addColumn method
- DataTablesContext class, context gather information from current request and is used for fetching data from DB
- Default listing template and renderer
- datatables min js script, jquery script and images 
