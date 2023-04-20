# NTAK.guru PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tmrw-life/ntak-guru-php-sdk.svg?style=flat-square)](https://packagist.org/packages/tmrw-life/ntak-guru-php-sdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/TMRW-Life/ntak.guru-php-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/TMRW-Life/ntak.guru-php-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/tmrw-life/ntak-guru-php-sdk.svg?style=flat-square)](https://packagist.org/packages/tmrw-life/ntak-guru-php-sdk)

NTAK.GURU is wrapper for [NTAK](https://info.ntak.hu) to provide a much simpler interface.

## Documentation

You can find the documentation [here](https://docs.ntakguru.tmrwsystem.life).

## Installation

You can install the package via composer:

```bash
composer require tmrw-life/ntak-guru-php-sdk
```

## Usage

## Accommodation

```php
use TmrwLife\NtakGuru\Entities\Accommodation as AccommodationEntity;

$accommodation = (new AccommodationEntity())
    ->setName('My Awesome Accommodation')
    ->setProviderName('Awesome provider Ltd')
    ->setProviderTaxNumber('12345678-1-41')
    ->setCountry('HU')
    ->setPostcode('M1 1AA')
    ->setLocality('Budapest');

$gateway = \TmrwLife\NtakGuru\Accommodation::setup('<your-access-token>');

// Create accommodation
$response = $gateway->store($accommodation);

$accommodationId = '00000000-0000-0000-0000-0000000'; // Provided by NTAK.guru

// Retrieve accommodation
$response = $gateway->show($accommodationId);

// Update accommodation
$response = $gateway->update($accommodationId, $accommodation);

// Activate accommodation
$response = $gateway->activate($accommodationId);

// Deactivate accommodation
$response = $gateway->deactivate($accommodationId);
```

### Certificates

```php
use TmrwLife\NtakGuru\Certificate;

$accommodationId = '00000000-0000-0000-0000-0000000'; // Provided by NTAK.guru

$gateway = Certificate::setup('<your-access-token>');

// Generate certificate (private key)
$gateway->generate($accommodationId);

// Download certificate (certificate request)
$gateway->download($accommodationId);

// Upload certificate (certificate)
$gateway->upload($accommodationId, '<content-of-certificate', '<reporting_id-provided-by-government-NTAK>');

// Delete certificate (private key and certificate request)
$gateway->destroy($accommodationId);
```

### Sending report

```php
use TmrwLife\NtakGuru\Entities\CheckIn;
use TmrwLife\NtakGuru\Entities\CheckOut;
use TmrwLife\NtakGuru\Entities\Reservation;
use TmrwLife\NtakGuru\Entities\RoomChange;
use TmrwLife\NtakGuru\Reporting;

$accommodationId = '00000000-0000-0000-0000-0000000'; // Provided by NTAK.guru

$reporting = Reporting::setup('<your-access-token>');

// Check-in report
$checkIn = (new CheckIn())->setAttribute('...');
$response = $reporting->checkIn($accommodationId, $checkIn);

// Check-out report
$checkOut = (new CheckOut())->setAttribute('...');
$response = $reporting->checkOut($accommodationId, $checkOut);

// Reservation report
$reservation = (new Reservation())->setAttribute('...');
$response = $reporting->reservation($accommodationId, $reservation);

// Room change report
$roomChange = (new RoomChange())->setAttribute('...');
$response = $reporting->roomChange($accommodationId, $roomChange);
```

### Entity builders

You can use the entity builders to create the entities.

We covered the 5 main report type with the entity builders.

| Name        | Builder                                  |
|-------------|------------------------------------------|
| Check-in    | `\TmrwLife\NtakGuru\Entites\CheckIn`     |
| Check-out   | `\TmrwLife\NtakGuru\Entites\CheckOut`    |
| Reservation | `\TmrwLife\NtakGuru\Entites\Reservation` |
| Room change | `\TmrwLife\NtakGuru\Entites\RoomChange`  |
| Daily close | soon                                     |

And a few more for properties.

| Name             | Builder                                      |
|------------------|----------------------------------------------|
| Guest            | `\TmrwLife\NtakGuru\Entites\Guest`           |
| Residential unit | `\TmrwLife\NtakGuru\Entites\ResidentialUnit` |
| soon             | More coming soon with Daily close            |

We also have some enums to help you with the attributes.

| Name                 | Enum                                          |
|----------------------|-----------------------------------------------|
| Charge item category | `\TmrwLife\NtakGuru\Enums\ChargeItemCategory` |
| Gender               | `\TmrwLife\NtakGuru\Enums\Gender`             |
| Market segment       | `\TmrwLife\NtakGuru\Enums\MarketSegment`      |
| Payment option       | `\TmrwLife\NtakGuru\Enums\PaymentOption`      |
| Residential unit     | `\TmrwLife\NtakGuru\Enums\ResidentialUnit`    |
| Sales channel        | `\TmrwLife\NtakGuru\Enums\SalesChannel`       |
| Tourist tax          | `\TmrwLife\NtakGuru\Enums\TouristTax`         |

For example:

```php
use TmrwLife\NtakGuru\Entities\Reservation;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;

$reservation = (new Reservation())
    ->setReservationNumber(23597)
    ->setOccurredAt('2023-04-19 14:00:23')
    ->setReservedAt('2023-04-19 13:46:04')
    ->setCancelled(false)
    ->setNationality('hu')
    ->setArrival('2023-04-21')
    ->setDeparture('2023-04-23')
    ->setSalesChannel(SalesChannel::DIRECTLY_ONLINE)
    ->setMarketSegment(MarketSegment::BUSINESS_GROUP)
    ->setGrossAmount(98700)
    ->setGuestCount(2)
    ->addBookedResidentialUnits(type: ResidentialUnitType::APARTMENT, capacity: 2);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Levente Otta](https://github.com/Otisz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
