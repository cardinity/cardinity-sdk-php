# Cardinity Client PHP Library

## v2.2.0

### Added
- Added `Method\Payment\ThreeDS2Data` class
- Added `Method\Payment\Address` class
- Added `Method\Payment\BrowserInfo` class
- Added `Method\Payment\TreeDS2AthorizationInformation` class

### Changed
- Updated `symfony/validator` to version v5.x
- Updated `phpspec/phpspec` to versin 5.1.2

## v2.1.0

### Added
- Added `isDeclined` method to `Payment` class
- Added `isApproved` and `isDeclined` methods to `Refund` class
- Added `isApproved` and `isDeclined` methods to `Settlement` class
- Added `isApproved` and `isDeclined` methods to `VoidPayment` class

## v2.0.0

### Changed
- Renamed `Cardinity\Method\Void` to `Cardinity\Method\VoidPayment`
- Renamed `Void.php` to `VoidPayment.php`

### Removed
- Removed `ResultObjectPropertyNotFound.php`
