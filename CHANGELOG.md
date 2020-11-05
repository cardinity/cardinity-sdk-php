# Cardinity Client PHP Library

## v2.2.0

### Added
- Added `threeDS2AuthorizationInformation` property to `Payment` class
- Added `getThreeds2data` method to `Payment` class
- Added `setThreeds2data` method to `Payment` class
- Added `isThreedsV1` method to `Payment` class
- Added `isThreedsV2` method to `Payment` class
- Added `getThreeDS2DataConstraints` method to `Create` class
- Added `getBrowserInfoConstraints` method to `Create` class
- Added `getAdressConstraints` method to `Create` class
- Added `getCardHolderInfoConstraints` method to `Create` class
- Added `buildElement` method to `Create` class
- Added `paymentId` property to `Finalize` class
- Added `finalizeKey` property to `Finalize` class
- Added `Method\Payment\ThreeDS2Data` parameters
- Added `Method\Payment\TreeDS2AthorizationInformation` class

### Changed
- Refactored `Create` class to build validation parameters using `buildElement` method
- Updated `getValidationConstraints` method of `Create` class
- Updated `getPaymentInstrumentConstraints` method of `Create` class
- Updated `__construct` method of `Finalize` class
- Updated `getAttributes` method of `Finalize` class
- Updated `getValidationConstraints` method of `Finalize` class
- Updated library `symfony/validator` to version v5.x
- Updated library `phpspec/phpspec` to versin 5.1.2

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
