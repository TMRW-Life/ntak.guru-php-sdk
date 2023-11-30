<?php

namespace TmrwLife\NtakGuru\Tests\Entities\Ntak;

use TmrwLife\NtakGuru\Entities\Ntak\CheckOutDaySale;
use TmrwLife\NtakGuru\Entities\Ntak\DailyClose;
use TmrwLife\NtakGuru\Entities\Ntak\Expense;
use TmrwLife\NtakGuru\Entities\Ntak\Guest;
use TmrwLife\NtakGuru\Entities\Ntak\Load;
use TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnit;
use TmrwLife\NtakGuru\Entities\Ntak\ResidentialUnitNight;
use TmrwLife\NtakGuru\Enums\ChargeItemCategory;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\PaymentOption;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class DailyCloseTest extends TestCase
{
    use WithFaker;

    public function testItBuildsTheDailyClose(): void
    {
        $afterStayExpense = (new Expense())
            ->setAmount($afterStayExpenseAmount = $this->faker->randomFloat())
            ->setDate($afterStayExpenseDate = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setPaymentOption($afterStayExpensePaymentOption = PaymentOption::CARD);

        $afterStayLoad = (new Load())
            ->setAmount($afterStayLoadAmount = $this->faker->randomFloat())
            ->setCategory($afterStayLoadCategory = ChargeItemCategory::ACCOMMODATION_FEE)
            ->setDate($afterStayLoadDate = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setIsTouristTax($afterStayLoadIsTouristTax = $this->faker->boolean())
            ->setTaxPercentage($afterStayLoadTaxPercentage = $this->faker->numberBetween(0, 100));

        $checkOutDaySaleExpense = (new Expense())
            ->setAmount($checkOutDaySaleExpenseAmount = $this->faker->randomFloat())
            ->setDate($checkOutDaySaleExpenseDate = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setPaymentOption($checkOutDaySaleExpensePaymentOption = PaymentOption::CASH);

        $checkOutDaySaleLoad = (new Load())
            ->setAmount($checkOutDaySaleLoadAmount = $this->faker->randomFloat())
            ->setCategory($checkOutDaySaleLoadCategory = ChargeItemCategory::DRINK)
            ->setDate($checkOutDaySaleLoadDate = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setIsTouristTax($checkOutDaySaleLoadIsTouristTax = $this->faker->boolean())
            ->setTaxPercentage($checkOutDaySaleLoadTaxPercentage = $this->faker->numberBetween(0, 100));

        $checkOutDaySaleResidentialUnit = (new ResidentialUnit())
            ->setType($checkOutDaySaleResidentialUnitType = ResidentialUnitType::ECONOMY)
            ->setBuilding($checkOutDaySaleResidentialUnitBuilding = $this->faker->randomLetter())
            ->setNumber($checkOutDaySaleResidentialUnitNumber = $this->faker->randomDigit())
            ->setSingleBedCount($checkOutDaySaleResidentialUnitSingleBedCount = $this->faker->randomDigit())
            ->setDoubleBedCount($checkOutDaySaleResidentialUnitDoubleBedCount = $this->faker->randomDigit())
            ->setTrundleBedCount($checkOutDaySaleResidentialUnitTrundleBedCount = $this->faker->randomDigit());

        $checkOutDaySale = (new CheckOutDaySale())
            ->addExpense($checkOutDaySaleExpense)
            ->addLoad($checkOutDaySaleLoad)
            ->setMarketSegment($checkOutDaySaleMarketSegment = MarketSegment::BUSINESS_GROUP)
            ->setReservationNumber($checkOutDaySaleReservationNumber = $this->faker->uuid())
            ->setResidentialUnit($checkOutDaySaleResidentialUnit)
            ->setSalesChannel($checkOutDaySaleSalesChannel = SalesChannel::DIRECT_TRADITIONAL);

        $otherExpense = (new Expense())
            ->setAmount($otherExpenseAmount = $this->faker->randomFloat())
            ->setDate($otherExpenseDate = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setPaymentOption($otherExpensePaymentOption = PaymentOption::RETROSPECTIVE);

        $otherLoad = (new Load())
            ->setAmount($otherLoadAmount = $this->faker->randomFloat())
            ->setCategory($otherLoadCategory = ChargeItemCategory::HEALTH_AND_WELLNESS)
            ->setDate($otherLoadDate = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setTaxPercentage($otherLoadTaxPercentage = $this->faker->numberBetween(0, 100));

        $outOfServiceResidentialUnit = (new ResidentialUnit())
            ->setType($outOfOrderResidentialUnitType = ResidentialUnitType::DORMITORY_BED)
            ->setBuilding($outOfServiceResidentialUnitBuilding = $this->faker->randomLetter())
            ->setNumber($outOfServiceResidentialUnitNumber = $this->faker->randomDigit())
            ->setSingleBedCount($outOfServiceResidentialUnitSingleBedCount = $this->faker->randomDigit())
            ->setDoubleBedCount($outOfServiceResidentialUnitDoubleBedCount = $this->faker->randomDigit())
            ->setTrundleBedCount($outOfServiceResidentialUnitTrundleBedCount = $this->faker->randomDigit());

        $residentialUnitNightExpense = (new Expense())
            ->setDate($residentialUnitNightExpenseDate = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setAmount($residentialUnitNightExpenseAmount = $this->faker->randomFloat())
            ->setPaymentOption($residentialUnitNightExpensePaymentOption = PaymentOption::SZEP)
            ->setPaymentOptionSubtype($residentialUnitNightExpensePaymentOptionSubtype = $this->faker->word());

        $residentialUnitNightGuest = (new Guest())
            ->setGender($residentialUnitNightGuestGender = Gender::MALE)
            ->setGuestNumber($residentialUnitNightGuestGuestNumber = $this->faker->randomDigit())
            ->setNationalityCountryCode($residentialUnitNightGuestNationalityCountryCode = $this->faker->countryCode())
            ->setResidencePostCode($residentialUnitNightGuestResidencePostCode = $this->faker->postcode())
            ->setResidenceCountryCode($residentialUnitNightGuestResidenceCountryCode = $this->faker->countryCode())
            ->setTouristTaxStatus($residentialUnitNightGuestTouristTax = TouristTax::OBLIGED)
            ->setYearOfBirth($residentialUnitNightGuestYearOfBirth = (int)$this->faker->year());

        $residentialUnitNightLoad = (new Load())
            ->setAmount($residentialUnitNightLoadAmount = $this->faker->randomFloat())
            ->setCategory($residentialUnitNightLoadCategory = ChargeItemCategory::DRINK)
            ->setDate($residentialUnitNightLoadDate = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setIsTouristTax($residentialUnitNightLoadIsTouristTax = $this->faker->boolean())
            ->setTaxPercentage($residentialUnitNightLoadTaxPercentage = $this->faker->numberBetween(0, 100));

        $residentialUnitNightResidentialUnit = (new ResidentialUnit())
            ->setType($residentialUnitNightResidentialUnitType = ResidentialUnitType::PRIVATE_ROOM_WITH_OWN_BATH)
            ->setBuilding($residentialUnitNightResidentialUnitBuilding = $this->faker->randomLetter())
            ->setNumber($residentialUnitNightResidentialUnitNumber = $this->faker->randomDigit())
            ->setSingleBedCount($residentialUnitNightResidentialUnitSingleBedCount = $this->faker->randomDigit())
            ->setDoubleBedCount($residentialUnitNightResidentialUnitDoubleBedCount = $this->faker->randomDigit())
            ->setTrundleBedCount($residentialUnitNightResidentialUnitTrundleBedCount = $this->faker->randomDigit());

        $residentialUnitNight = (new ResidentialUnitNight())
            ->setDayUse($residentialUnitNightDayUse = $this->faker->boolean())
            ->addExpense($residentialUnitNightExpense)
            ->addGuest($residentialUnitNightGuest)
            ->addLoad($residentialUnitNightLoad)
            ->setMarketSegment($residentialUnitNightMarketSegment = MarketSegment::LEISURE_GROUP)
            ->setReservationNumber($residentialUnitNightReservationNumber = $this->faker->uuid())
            ->setResidentialUnit($residentialUnitNightResidentialUnit)
            ->setSalesChannel($residentialUnitNightSalesChannel = SalesChannel::AGENCY_TRADITIONAL);

        $dailyClose = (new DailyClose())
            ->setClosedDay($closedDay = $this->faker->date())
            ->setResidentialUnits(
                all: $all = $this->faker->randomDigit(),
                ooo: $ooo = $this->faker->randomDigit(),
                oos: $oos = $this->faker->randomDigit(),
                occupied: $occupied = $this->faker->randomDigit(),
                available: $available = $this->faker->randomDigit(),
            )
            ->addAfterStayExpense($afterStayExpense)
            ->addAfterStayLoad($afterStayLoad)
            ->addCheckOutDaySale($checkOutDaySale)
            ->addOtherExpense($otherExpense)
            ->addOtherLoad($otherLoad)
            ->addOutOfOrderResidentialUnit($outOfServiceResidentialUnit)
            ->addResidentialUnitNight($residentialUnitNight)
            ->toArray();

        $this->assertSame($closedDay, $dailyClose['closedDay']);

        $this->assertSame($all, $dailyClose['residentialUnits']['all']);
        $this->assertSame($ooo, $dailyClose['residentialUnits']['ooo']);
        $this->assertSame($oos, $dailyClose['residentialUnits']['oos']);
        $this->assertSame($occupied, $dailyClose['residentialUnits']['occupied']);
        $this->assertSame($available, $dailyClose['residentialUnits']['available']);

        $this->assertSame($afterStayExpenseAmount, $dailyClose['afterStayExpenses'][0]['amount']);
        $this->assertSame($afterStayExpenseDate, $dailyClose['afterStayExpenses'][0]['date']);
        $this->assertSame($afterStayExpensePaymentOption->value, $dailyClose['afterStayExpenses'][0]['paymentOption']);

        $this->assertSame($afterStayLoadAmount, $dailyClose['afterStayLoads'][0]['amount']);
        $this->assertSame($afterStayLoadCategory->value, $dailyClose['afterStayLoads'][0]['category']);
        $this->assertSame($afterStayLoadDate, $dailyClose['afterStayLoads'][0]['date']);
        $this->assertSame($afterStayLoadIsTouristTax, $dailyClose['afterStayLoads'][0]['isTouristTax']);
        $this->assertSame($afterStayLoadTaxPercentage, $dailyClose['afterStayLoads'][0]['taxPercentage']);

        $this->assertSame($checkOutDaySaleExpenseAmount, $dailyClose['checkOutDaySales'][0]['expenses'][0]['amount']);
        $this->assertSame($checkOutDaySaleExpenseDate, $dailyClose['checkOutDaySales'][0]['expenses'][0]['date']);
        $this->assertSame($checkOutDaySaleExpensePaymentOption->value, $dailyClose['checkOutDaySales'][0]['expenses'][0]['paymentOption']);

        $this->assertSame($checkOutDaySaleLoadAmount, $dailyClose['checkOutDaySales'][0]['loads'][0]['amount']);
        $this->assertSame($checkOutDaySaleLoadCategory->value, $dailyClose['checkOutDaySales'][0]['loads'][0]['category']);
        $this->assertSame($checkOutDaySaleLoadDate, $dailyClose['checkOutDaySales'][0]['loads'][0]['date']);
        $this->assertSame($checkOutDaySaleLoadIsTouristTax, $dailyClose['checkOutDaySales'][0]['loads'][0]['isTouristTax']);
        $this->assertSame($checkOutDaySaleLoadTaxPercentage, $dailyClose['checkOutDaySales'][0]['loads'][0]['taxPercentage']);

        $this->assertSame($checkOutDaySaleResidentialUnitType->value, $dailyClose['checkOutDaySales'][0]['residentialUnit']['type']);
        $this->assertSame($checkOutDaySaleResidentialUnitBuilding, $dailyClose['checkOutDaySales'][0]['residentialUnit']['building']);
        $this->assertSame($checkOutDaySaleResidentialUnitNumber, $dailyClose['checkOutDaySales'][0]['residentialUnit']['number']);
        $this->assertSame($checkOutDaySaleResidentialUnitSingleBedCount, $dailyClose['checkOutDaySales'][0]['residentialUnit']['singleBedCount']);
        $this->assertSame($checkOutDaySaleResidentialUnitDoubleBedCount, $dailyClose['checkOutDaySales'][0]['residentialUnit']['doubleBedCount']);
        $this->assertSame($checkOutDaySaleResidentialUnitTrundleBedCount, $dailyClose['checkOutDaySales'][0]['residentialUnit']['trundleBedCount']);

        $this->assertSame($checkOutDaySaleMarketSegment->value, $dailyClose['checkOutDaySales'][0]['marketSegment']);
        $this->assertSame($checkOutDaySaleReservationNumber, $dailyClose['checkOutDaySales'][0]['reservationNumber']);
        $this->assertSame($checkOutDaySaleSalesChannel->value, $dailyClose['checkOutDaySales'][0]['salesChannel']);

        $this->assertSame($otherExpenseAmount, $dailyClose['otherExpenses'][0]['amount']);
        $this->assertSame($otherExpenseDate, $dailyClose['otherExpenses'][0]['date']);
        $this->assertSame($otherExpensePaymentOption->value, $dailyClose['otherExpenses'][0]['paymentOption']);

        $this->assertSame($otherLoadAmount, $dailyClose['otherLoads'][0]['amount']);
        $this->assertSame($otherLoadCategory->value, $dailyClose['otherLoads'][0]['category']);
        $this->assertSame($otherLoadDate, $dailyClose['otherLoads'][0]['date']);
        $this->assertSame($otherLoadTaxPercentage, $dailyClose['otherLoads'][0]['taxPercentage']);

        $this->assertSame($outOfOrderResidentialUnitType->value, $dailyClose['outOfOrderResidentialUnits'][0]['type']);
        $this->assertSame($outOfServiceResidentialUnitBuilding, $dailyClose['outOfOrderResidentialUnits'][0]['building']);
        $this->assertSame($outOfServiceResidentialUnitNumber, $dailyClose['outOfOrderResidentialUnits'][0]['number']);
        $this->assertSame($outOfServiceResidentialUnitSingleBedCount, $dailyClose['outOfOrderResidentialUnits'][0]['singleBedCount']);
        $this->assertSame($outOfServiceResidentialUnitDoubleBedCount, $dailyClose['outOfOrderResidentialUnits'][0]['doubleBedCount']);
        $this->assertSame($outOfServiceResidentialUnitTrundleBedCount, $dailyClose['outOfOrderResidentialUnits'][0]['trundleBedCount']);

        $this->assertSame($residentialUnitNightExpenseDate, $dailyClose['residentialUnitNights'][0]['expenses'][0]['date']);
        $this->assertSame($residentialUnitNightExpenseAmount, $dailyClose['residentialUnitNights'][0]['expenses'][0]['amount']);
        $this->assertSame($residentialUnitNightExpensePaymentOption->value, $dailyClose['residentialUnitNights'][0]['expenses'][0]['paymentOption']);
        $this->assertSame($residentialUnitNightExpensePaymentOptionSubtype, $dailyClose['residentialUnitNights'][0]['expenses'][0]['paymentOptionSubtype']);

        $this->assertSame($residentialUnitNightGuestGender->value, $dailyClose['residentialUnitNights'][0]['guests'][0]['gender']);
        $this->assertSame($residentialUnitNightGuestGuestNumber, $dailyClose['residentialUnitNights'][0]['guests'][0]['guestNumber']);
        $this->assertSame($residentialUnitNightGuestNationalityCountryCode, $dailyClose['residentialUnitNights'][0]['guests'][0]['nationalityCountryCode']);
        $this->assertSame($residentialUnitNightGuestResidencePostCode, $dailyClose['residentialUnitNights'][0]['guests'][0]['residencePostCode']);
        $this->assertSame($residentialUnitNightGuestResidenceCountryCode, $dailyClose['residentialUnitNights'][0]['guests'][0]['residenceCountryCode']);
        $this->assertSame($residentialUnitNightGuestTouristTax->value, $dailyClose['residentialUnitNights'][0]['guests'][0]['touristTaxStatus']);
        $this->assertSame($residentialUnitNightGuestYearOfBirth, $dailyClose['residentialUnitNights'][0]['guests'][0]['yearOfBirth']);

        $this->assertSame($residentialUnitNightLoadDate, $dailyClose['residentialUnitNights'][0]['loads'][0]['date']);
        $this->assertSame($residentialUnitNightLoadAmount, $dailyClose['residentialUnitNights'][0]['loads'][0]['amount']);
        $this->assertSame($residentialUnitNightLoadCategory->value, $dailyClose['residentialUnitNights'][0]['loads'][0]['category']);
        $this->assertSame($residentialUnitNightLoadIsTouristTax, $dailyClose['residentialUnitNights'][0]['loads'][0]['isTouristTax']);
        $this->assertSame($residentialUnitNightLoadTaxPercentage, $dailyClose['residentialUnitNights'][0]['loads'][0]['taxPercentage']);

        $this->assertSame($residentialUnitNightResidentialUnitType->value, $dailyClose['residentialUnitNights'][0]['residentialUnit']['type']);
        $this->assertSame($residentialUnitNightResidentialUnitBuilding, $dailyClose['residentialUnitNights'][0]['residentialUnit']['building']);
        $this->assertSame($residentialUnitNightResidentialUnitNumber, $dailyClose['residentialUnitNights'][0]['residentialUnit']['number']);
        $this->assertSame($residentialUnitNightResidentialUnitSingleBedCount, $dailyClose['residentialUnitNights'][0]['residentialUnit']['singleBedCount']);
        $this->assertSame($residentialUnitNightResidentialUnitDoubleBedCount, $dailyClose['residentialUnitNights'][0]['residentialUnit']['doubleBedCount']);
        $this->assertSame($residentialUnitNightResidentialUnitTrundleBedCount, $dailyClose['residentialUnitNights'][0]['residentialUnit']['trundleBedCount']);

        $this->assertSame($residentialUnitNightDayUse, $dailyClose['residentialUnitNights'][0]['dayUse']);
        $this->assertSame($residentialUnitNightMarketSegment->value, $dailyClose['residentialUnitNights'][0]['marketSegment']);
        $this->assertSame($residentialUnitNightReservationNumber, $dailyClose['residentialUnitNights'][0]['reservationNumber']);
        $this->assertSame($residentialUnitNightSalesChannel->value, $dailyClose['residentialUnitNights'][0]['salesChannel']);
    }

    public function testItBuildsTheDailyCloseWithAccommodationNotOperating(): void
    {
        $dailyClose = (new DailyClose())
            ->setClosedDay($closedDay = $this->faker->date())
            ->setResidentialUnits(
                all: $all = $this->faker->randomDigit(),
                ooo: $ooo = $this->faker->randomDigit(),
                oos: $oos = $this->faker->randomDigit(),
                occupied: $occupied = $this->faker->randomDigit(),
                available: $available = $this->faker->randomDigit(),
            )
            ->accommodationNotOperating()
            ->toArray();

        $this->assertSame($closedDay, $dailyClose['closedDay']);
        $this->assertSame($all, $dailyClose['residentialUnits']['all']);
        $this->assertSame($ooo, $dailyClose['residentialUnits']['ooo']);
        $this->assertSame($oos, $dailyClose['residentialUnits']['oos']);
        $this->assertSame($occupied, $dailyClose['residentialUnits']['occupied']);
        $this->assertSame($available, $dailyClose['residentialUnits']['available']);
        $this->assertTrue($dailyClose['accommodationNotOperating']);
    }

    public function testItBuildsTheDailyCloseWithMinimalData(): void
    {
        $dailyClose = (new DailyClose())
            ->setClosedDay($closedDay = $this->faker->date())
            ->setResidentialUnits(
                all: $all = $this->faker->randomDigit(),
                ooo: $ooo = $this->faker->randomDigit(),
                oos: $oos = $this->faker->randomDigit(),
                occupied: $occupied = $this->faker->randomDigit(),
                available: $available = $this->faker->randomDigit(),
            )
            ->toArray();

        $this->assertSame($closedDay, $dailyClose['closedDay']);
        $this->assertSame($all, $dailyClose['residentialUnits']['all']);
        $this->assertSame($ooo, $dailyClose['residentialUnits']['ooo']);
        $this->assertSame($oos, $dailyClose['residentialUnits']['oos']);
        $this->assertSame($occupied, $dailyClose['residentialUnits']['occupied']);
        $this->assertSame($available, $dailyClose['residentialUnits']['available']);
        $this->assertEmpty($dailyClose['afterStayExpenses']);
        $this->assertEmpty($dailyClose['afterStayLoads']);
        $this->assertEmpty($dailyClose['checkOutDaySales']);
        $this->assertEmpty($dailyClose['otherExpenses']);
        $this->assertEmpty($dailyClose['otherLoads']);
        $this->assertEmpty($dailyClose['outOfOrderResidentialUnits']);
    }
}
