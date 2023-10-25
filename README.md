# NTAK.guru PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tmrw-life/ntak-guru-php-sdk.svg?style=flat-square)](https://packagist.org/packages/tmrw-life/ntak-guru-php-sdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/TMRW-Life/ntak.guru-php-sdk/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/TMRW-Life/ntak.guru-php-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/tmrw-life/ntak-guru-php-sdk.svg?style=flat-square)](https://packagist.org/packages/tmrw-life/ntak-guru-php-sdk)

NTAK.GURU is wrapper for [NTAK](https://info.ntak.hu) to provide a much simpler interface.

## Documentation

You can find the documentation [here](https://docs.ntak.guru).

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

$gateway = \TmrwLife\NtakGuru\Services\Accommodation::setup([
    'accessToken' => '<your-access-token>',
    'isProduction' => false, // default: false
]);

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
use TmrwLife\NtakGuru\Services\Certificate;

$accommodationId = '00000000-0000-0000-0000-0000000'; // Provided by NTAK.guru

$gateway = Certificate::setup([
    'accessToken' => '<your-access-token>',
    'isProduction' => false, // default: false
]);

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
use TmrwLife\NtakGuru\Entities\Ntak\CheckIn;
use TmrwLife\NtakGuru\Entities\Ntak\CheckOut;
use TmrwLife\NtakGuru\Entities\Ntak\Reservation;
use TmrwLife\NtakGuru\Entities\Ntak\RoomChange;
use TmrwLife\NtakGuru\Services\Reporting\Ntak;

$accommodationId = '00000000-0000-0000-0000-0000000'; // Provided by NTAK.guru

$reporting = Ntak::setup([
    'accessToken' => '<your-access-token>',
    'isProduction' => false, // default: false
]);

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

| Name        | Builder                                        |
|-------------|------------------------------------------------|
| Check-in    | `\TmrwLife\NtakGuru\Entities\Ntak\CheckIn`     |
| Check-out   | `\TmrwLife\NtakGuru\Entities\Ntak\CheckOut`    |
| Reservation | `\TmrwLife\NtakGuru\Entities\Ntak\Reservation` |
| Room change | `\TmrwLife\NtakGuru\Entities\Ntak\RoomChange`  |
| Daily close | `\TmrwLife\NtakGuru\Entities\Ntak\DailyClose`  |

And a few more for properties.

| Name                   | Builder                                                 |
|------------------------|---------------------------------------------------------|
| Guest                  | `\TmrwLife\NtakGuru\Entities\Ntak\Guest`                |
| Residential unit       | `\TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnit`      |
| Checkout Day Sale      | `\TmrwLife\NtakGuru\Entities\Ntak\CheckOutDaySale`      |
| Expense                | `\TmrwLife\NtakGuru\Entities\Ntak\Expense`              |
| Load                   | `\TmrwLife\NtakGuru\Entities\Ntak\Load`                 |
| Residential unit night | `\TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnitNight` |

We also have some enums to help you with the attributes.

| Name                 | Enum                                          |
|----------------------|-----------------------------------------------|
| Charge item category | `\TmrwLife\NtakGuru\Enums\ChargeItemCategory` |
| DocumentType         | `\TmrwLife\NtakGuru\Enums\DocumentType`       |
| Gender               | `\TmrwLife\NtakGuru\Enums\Gender`             |
| Market segment       | `\TmrwLife\NtakGuru\Enums\MarketSegment`      |
| Payment option       | `\TmrwLife\NtakGuru\Enums\PaymentOption`      |
| Residential unit     | `\TmrwLife\NtakGuru\Enums\ResidentialUnit`    |
| Sales channel        | `\TmrwLife\NtakGuru\Enums\SalesChannel`       |
| Tourist tax          | `\TmrwLife\NtakGuru\Enums\TouristTax`         |

For example:

```php
use TmrwLife\NtakGuru\Entities\Ntak\Reservation;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;

$reservation = (new Reservation())
    ->setReservationNumber(23597)
    ->setOccurredAt('2023-04-19 14:00:23')
    ->setReservedAt('2023-04-19 13:46:04')
    ->setCancelled(false)
    ->setNationality('hu')
    ->setArrival('2023-04-21')
    ->setDeparture('2023-04-23')
    ->setSalesChannel(SalesChannel::DIRECT_ONLINE)
    ->setMarketSegment(MarketSegment::BUSINESS_GROUP)
    ->setGrossAmount(98700)
    ->setGuestCount(2)
    ->addBookedResidentialUnits(type: ResidentialUnitType::APARTMENT, capacity: 2);
```

### Daily close response

In order to respond to the daily close request, you can use the `DailyClose` entity builder class.

```php
use TmrwLife\NtakGuru\Crypt;
use TmrwLife\NtakGuru\Entities\Ntak\CheckOutDaySale;
use TmrwLife\NtakGuru\Entities\Ntak\DailyClose;
use TmrwLife\NtakGuru\Entities\Ntak\Expense;
use TmrwLife\NtakGuru\Entities\Ntak\Load;
use TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnit;
use TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnitNight;

$dailyClose = (new DailyClose())
    ->setClosedDay('2023-04-20')
    ->setResidentialUnits(
        all: 15,
        ooo: 0,
        oos: 2,
        occupied: 10,
        available: 3,
    )
    ->addAfterStayExpense(new Expense())
    ->addAfterStayLoad(new Load())
    ->addCheckOutDaySale(new CheckOutDaySale())
    ->addOtherExpense(new Expense())
    ->addOtherLoad(new Load())
    ->addOutOfServiceResidentialUnit(new ResidentialUnit())
    ->addResidentialUnitNight(new ResidentialUnitNight());

$data = Crypt::seal($dailyClose->toArray());

return $data; // JSON response to NTAK.guru
```

Or if the accommodation is no operating

```php
use TmrwLife\NtakGuru\Crypt;
use TmrwLife\NtakGuru\Entities\Ntak\DailyClose;

$dailyClose = (new DailyClose())
    ->setClosedDay('2023-04-20')
    ->setResidentialUnits(
        all: $all = $this->faker->randomDigit(),
        ooo: $ooo = $this->faker->randomDigit(),
        oos: $oos = $this->faker->randomDigit(),
        occupied: $occupied = $this->faker->randomDigit(),
        available: $available = $this->faker->randomDigit(),
    )
    ->accommodationNotOperating();

$data = Crypt::seal($dailyClose->toArray());

return $data; // JSON response to NTAK.guru
```

### Validation

You can validate the request data with the `Validator` class.

Since we can not provide staging/sandbox environment, this will help you to test your code in development.

```php
use TmrwLife\NtakGuru\Entities\Ntak\Reservation;
use TmrwLife\NtakGuru\Validation\Ntak\Validator;

$reservation = new Reservation();

$validator = Validator::parse($reservation);

if (!$validator->validate()) {
    $validator->getErrors();
    // handle validation errors
}

# ... validation passed
```

## VIZA

### Sending report

```php
use TmrwLife\NtakGuru\Entities\Ntak\CheckIn;
use TmrwLife\NtakGuru\Entities\Ntak\CheckOut;
use TmrwLife\NtakGuru\Services\Reporting\Viza;

$accommodationId = '00000000-0000-0000-0000-0000000'; // Provided by NTAK.guru

$reporting = Viza::setup([
    'accessToken' => '<your-access-token>',
    'isProduction' => false, // default: false
]);

// Check-in report
$checkIn = (new CheckIn())->setAttribute('...');
$response = $reporting->checkIn($accommodationId, $checkIn);

// Check-out report
$checkOut = (new CheckOut())->setAttribute('...');
$response = $reporting->checkOut($accommodationId, $checkOut);

// Fetch status
$response = $reporting->status($accommodationId);

// Fetch unsent data
$response = $reporting->unsentData($accommodationId);
```

### Entity builders

You can use the entity builders to create the entities.

We covered the 2 main report type with the entity builders.

| Name        | Builder                                     |
|-------------|---------------------------------------------|
| Check-in    | `\TmrwLife\NtakGuru\Entities\Viza\CheckIn`  |
| Check-out   | `\TmrwLife\NtakGuru\Entities\Viza\CheckOut` |

And a few more for properties.

| Name                   | Builder                                          |
|------------------------|--------------------------------------------------|
| Guest                  | `\TmrwLife\NtakGuru\Entities\Viza\Guest`         |
| Guest Document         | `\TmrwLife\NtakGuru\Entities\Ntak\GuestDocument` |

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
