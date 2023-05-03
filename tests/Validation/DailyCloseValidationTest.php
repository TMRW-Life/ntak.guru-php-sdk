<?php

namespace TmrwLife\NtakGuru\Tests\Validation;

use TmrwLife\NtakGuru\Entities\CheckOutDaySale;
use TmrwLife\NtakGuru\Entities\DailyClose;
use TmrwLife\NtakGuru\Entities\Expense;
use TmrwLife\NtakGuru\Entities\Guest;
use TmrwLife\NtakGuru\Entities\Load;
use TmrwLife\NtakGuru\Entities\ResidentialUnit;
use TmrwLife\NtakGuru\Entities\ResidentialUnitNight;
use TmrwLife\NtakGuru\Enums\ChargeItemCategory;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\PaymentOption;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;
use TmrwLife\NtakGuru\Validation\Validator;

class DailyCloseValidationTest extends TestCase
{
    use WithFaker;

    public function testItDailyCloseValidationSuccess(): void
    {
        $afterStayExpense = (new Expense())
            ->setAmount($this->faker->randomFloat())
            ->setDate($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setPaymentOption(PaymentOption::from($this->faker->randomElement(PaymentOption::values())))
            ->setPaymentOptionSubtype($this->faker->word());

        $afterStayLoad = (new Load())
            ->setAmount($this->faker->randomFloat())
            ->setCategory(ChargeItemCategory::from($this->faker->randomElement(ChargeItemCategory::values())))
            ->setDate($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setIsTouristTax($this->faker->boolean())
            ->setTaxPercentage($this->faker->numberBetween(0, 100));

        $checkOutDaySaleExpense = (new Expense())
            ->setAmount($this->faker->randomFloat())
            ->setDate($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setPaymentOption(PaymentOption::from($this->faker->randomElement(PaymentOption::values())))
            ->setPaymentOptionSubtype($this->faker->word());

        $checkOutDaySaleLoad = (new Load())
            ->setAmount($this->faker->randomFloat())
            ->setCategory(ChargeItemCategory::from($this->faker->randomElement(ChargeItemCategory::values())))
            ->setDate($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setIsTouristTax($this->faker->boolean())
            ->setTaxPercentage($this->faker->numberBetween(0, 100));

        $checkOutDaySaleResidentialUnit = (new ResidentialUnit())
            ->setType(ResidentialUnitType::from($this->faker->randomElement(ResidentialUnitType::values())))
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomDigit())
            ->setSingleBedCount($this->faker->randomDigit())
            ->setDoubleBedCount($this->faker->randomDigit())
            ->setTrundleBedCount($this->faker->randomDigit());

        $checkOutDaySale = (new CheckOutDaySale())
            ->addExpense($checkOutDaySaleExpense)
            ->addLoad($checkOutDaySaleLoad)
            ->setMarketSegment(MarketSegment::from($this->faker->randomElement(MarketSegment::values())))
            ->setReservationNumber($this->faker->uuid())
            ->setResidentialUnit($checkOutDaySaleResidentialUnit)
            ->setSalesChannel(SalesChannel::from($this->faker->randomElement(SalesChannel::values())));

        $otherExpense = (new Expense())
            ->setAmount($this->faker->randomFloat())
            ->setDate($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setPaymentOption(PaymentOption::from($this->faker->randomElement(PaymentOption::values())))
            ->setPaymentOptionSubtype($this->faker->word());

        $otherLoad = (new Load())
            ->setAmount($this->faker->randomFloat())
            ->setCategory(ChargeItemCategory::from($this->faker->randomElement(ChargeItemCategory::values())))
            ->setDate($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setTaxPercentage($this->faker->numberBetween(0, 100));

        $outOfServiceResidentialUnit = (new ResidentialUnit())
            ->setType(ResidentialUnitType::from($this->faker->randomElement(ResidentialUnitType::values())))
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomDigit())
            ->setSingleBedCount($this->faker->randomDigit())
            ->setDoubleBedCount($this->faker->randomDigit())
            ->setTrundleBedCount($this->faker->randomDigit());

        $residentialUnitNightExpense = (new Expense())
            ->setDate($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setAmount($this->faker->randomFloat())
            ->setPaymentOption(PaymentOption::from($this->faker->randomElement(PaymentOption::values())))
            ->setPaymentOptionSubtype($this->faker->word());

        $residentialUnitNightGuest = (new Guest())
            ->setGender(Gender::from($this->faker->randomElement(Gender::values())))
            ->setGuestNumber($this->faker->randomDigit())
            ->setNationalityCountryCode($this->faker->countryCode())
            ->setResidencePostCode($this->faker->postcode())
            ->setResidenceCountryCode($this->faker->countryCode())
            ->setTouristTaxStatus(TouristTax::from($this->faker->randomElement(TouristTax::values())))
            ->setYearOfBirth((int) $this->faker->year());

        $residentialUnitNightLoad = (new Load())
            ->setAmount($this->faker->randomFloat())
            ->setCategory(ChargeItemCategory::from($this->faker->randomElement(ChargeItemCategory::values())))
            ->setDate($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setIsTouristTax($this->faker->boolean())
            ->setTaxPercentage($this->faker->numberBetween(0, 100));

        $residentialUnitNightResidentialUnit = (new ResidentialUnit())
            ->setType(ResidentialUnitType::from($this->faker->randomElement(ResidentialUnitType::values())))
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomDigit())
            ->setSingleBedCount($this->faker->randomDigit())
            ->setDoubleBedCount($this->faker->randomDigit())
            ->setTrundleBedCount($this->faker->randomDigit());

        $residentialUnitNight = (new ResidentialUnitNight())
            ->setDayUse($this->faker->boolean())
            ->addExpense($residentialUnitNightExpense)
            ->addGuest($residentialUnitNightGuest)
            ->addLoad($residentialUnitNightLoad)
            ->setMarketSegment(MarketSegment::from($this->faker->randomElement(MarketSegment::values())))
            ->setReservationNumber($this->faker->uuid())
            ->setResidentialUnit($residentialUnitNightResidentialUnit)
            ->setSalesChannel(SalesChannel::from($this->faker->randomElement(SalesChannel::values())));

        $dailyClose = (new DailyClose())
            ->setClosedDay($this->faker->date())
            ->setResidentialUnits(
                all: $this->faker->randomDigit(),
                ooo: $this->faker->randomDigit(),
                oos: $this->faker->randomDigit(),
                occupied: $this->faker->randomDigit(),
                available: $this->faker->randomDigit(),
            )
            ->addAfterStayExpense($afterStayExpense)
            ->addAfterStayLoad($afterStayLoad)
            ->addCheckOutDaySale($checkOutDaySale)
            ->addOtherExpense($otherExpense)
            ->addOtherLoad($otherLoad)
            ->addOutOfServiceResidentialUnit($outOfServiceResidentialUnit)
            ->addResidentialUnitNight($residentialUnitNight);

        $validator = Validator::parse($dailyClose);

        $this->assertTrue($validator->validate());
    }

    public function testItDailyCloseValidationFail(): void
    {
        $dailyClose = (new DailyClose());

        $validator = Validator::parse($dailyClose);

        $this->assertFalse($validator->validate());
    }
}
