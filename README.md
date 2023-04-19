# This is my package ntak-guru-php-sdk

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

### Sending report

```php
$accommodationId = '00000000-0000-0000-0000-0000000'; // Provided by NTAK.guru
$accessToken = '<your-access-token>';

$ntakGuru = \TmrwLife\NtakGuru\NtakGuru::accommodation($accommodationId, $accessToken);

// Check-in report
$checkIn = (new \TmrwLife\NtakGuru\Entities\CheckIn())->setAttribute('...');
$response = $ntakGuru->checkIn($checkIn);

// Check-out report
$checkOut = (new \TmrwLife\NtakGuru\Entities\CheckOut())->setAttribute('...');
$response = $ntakGuru->checkOut($checkOut);

// Reservation report
$reservation = (new \TmrwLife\NtakGuru\Entities\Reservation())->setAttribute('...');
$response = $ntakGuru->reservation($reservation);

// Room change report
$roomChange = (new \TmrwLife\NtakGuru\Entities\RoomChange())->setAttribute('...');
$response = $ntakGuru->roomChange($roomChange);
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
use TmrwLife\NtakGuru\Enums\ResidentialUnit;

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
            ->addBookedResidentialUnits(ResidentialUnit::APARTMENT, 2);
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
