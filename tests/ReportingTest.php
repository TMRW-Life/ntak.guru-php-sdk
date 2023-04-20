<?php

namespace TmrwLife\NtakGuru\Tests;

use GuzzleHttp\Exception\ClientException;
use TmrwLife\NtakGuru\Entities\CheckIn;
use TmrwLife\NtakGuru\Entities\CheckOut;
use TmrwLife\NtakGuru\Entities\Guest;
use TmrwLife\NtakGuru\Entities\Reservation;
use TmrwLife\NtakGuru\Entities\ResidentialUnit;
use TmrwLife\NtakGuru\Entities\RoomChange;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Enums\MarketSegment;
use TmrwLife\NtakGuru\Enums\ResidentialUnitType;
use TmrwLife\NtakGuru\Enums\SalesChannel;
use TmrwLife\NtakGuru\Enums\TouristTax;
use TmrwLife\NtakGuru\Reporting;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class ReportingTest extends TestCase
{
    use WithFaker;

    public function testItSendsCheckInRequest(): void
    {
        $guest = (new Guest())
            ->setGender(Gender::MALE)
            ->setGuestNumber($this->faker->uuid())
            ->setYearOfBirth($this->faker->year())
            ->setTouristTaxStatus(TouristTax::OBLIGED)
            ->setNationalityCountryCode($this->faker->countryCode())
            ->setResidencePostCode($this->faker->postcode())
            ->setResidenceCountryCode($this->faker->countryCode());

        $unit = (new ResidentialUnit())
            ->setType(ResidentialUnitType::APARTMENT)
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomNumber(2))
            ->setSingleBedCount($this->faker->randomNumber(1))
            ->setDoubleBedCount($this->faker->randomNumber(1))
            ->setTrundleBedCount($this->faker->randomNumber(1));

        $checkIn = (new CheckIn())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest)
            ->setOccupiedResidentialUnit($unit);

        $reporting = Reporting::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
                'messageId' => $messageId = $this->faker->uuid(),
                'status' => 'pending',
                'reason' => $reason = $this->faker->word(),
                'type' => 'check-in',
                'context' => 'context',
                'response' => null,
            ],
        ]);

        $report = $reporting->checkIn($this->faker->uuid(), $checkIn);

        $this->assertSame($id, $report['payload']['id']);
        $this->assertSame($messageId, $report['payload']['messageId']);
        $this->assertSame('pending', $report['payload']['status']);
        $this->assertSame($reason, $report['payload']['reason']);
        $this->assertSame('check-in', $report['payload']['type']);
        $this->assertSame('context', $report['payload']['context']);
        $this->assertNull($report['payload']['response']);
    }

    public function testItSendsCheckOutRequest(): void
    {
        $guest = (new Guest())
            ->setGender(Gender::MALE)
            ->setGuestNumber($this->faker->uuid())
            ->setYearOfBirth((int) $this->faker->year())
            ->setTouristTaxStatus(TouristTax::OBLIGED)
            ->setNationalityCountryCode($this->faker->countryCode())
            ->setResidencePostCode($this->faker->postcode())
            ->setResidenceCountryCode($this->faker->countryCode());

        $unit = (new ResidentialUnit())
            ->setType(ResidentialUnitType::APARTMENT)
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomNumber(2))
            ->setSingleBedCount($this->faker->randomNumber(1))
            ->setDoubleBedCount($this->faker->randomNumber(1))
            ->setTrundleBedCount($this->faker->randomNumber(1));

        $checkOut = (new CheckOut())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest)
            ->setAbandonedResidentialUnit($unit);

        $reporting = Reporting::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
                'messageId' => $messageId = $this->faker->uuid(),
                'status' => 'pending',
                'reason' => $reason = $this->faker->word(),
                'type' => 'check-out',
                'context' => 'context',
                'response' => null,
            ],
        ]);

        $report = $reporting->checkOut($this->faker->uuid(), $checkOut);

        $this->assertSame($id, $report['payload']['id']);
        $this->assertSame($messageId, $report['payload']['messageId']);
        $this->assertSame('pending', $report['payload']['status']);
        $this->assertSame($reason, $report['payload']['reason']);
        $this->assertSame('check-out', $report['payload']['type']);
        $this->assertSame('context', $report['payload']['context']);
        $this->assertNull($report['payload']['response']);
    }

    public function testItSendsReservationRequest(): void
    {
        $reservation = (new Reservation())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setReservedAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setCancelled($this->faker->boolean())
            ->setNationality($this->faker->countryCode())
            ->setArrival($this->faker->dateTime()->format('Y-m-d'))
            ->setDeparture($this->faker->dateTime()->format('Y-m-d'))
            ->setSalesChannel(SalesChannel::DIRECTLY_ONLINE)
            ->setMarketSegment(MarketSegment::BUSINESS_GROUP)
            ->setGrossAmount($this->faker->randomFloat(2, 0, 1000))
            ->setGuestCount($this->faker->randomNumber(1))
            ->addBookedResidentialUnits(ResidentialUnitType::APARTMENT, $this->faker->randomNumber(1));

        $reporting = Reporting::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
                'messageId' => $messageId = $this->faker->uuid(),
                'status' => 'pending',
                'reason' => $reason = $this->faker->word(),
                'type' => 'reservation',
                'context' => 'context',
                'response' => null,
            ],
        ]);

        $report = $reporting->reservation($this->faker->uuid(), $reservation);

        $this->assertSame($id, $report['payload']['id']);
        $this->assertSame($messageId, $report['payload']['messageId']);
        $this->assertSame('pending', $report['payload']['status']);
        $this->assertSame($reason, $report['payload']['reason']);
        $this->assertSame('reservation', $report['payload']['type']);
        $this->assertSame('context', $report['payload']['context']);
        $this->assertNull($report['payload']['response']);
    }

    public function testItSendsRoomChangeRequest(): void
    {
        $guest = (new Guest())
            ->setGender(Gender::MALE)
            ->setGuestNumber($this->faker->uuid())
            ->setYearOfBirth((int) $this->faker->year())
            ->setTouristTaxStatus(TouristTax::OBLIGED)
            ->setNationalityCountryCode($this->faker->countryCode())
            ->setResidencePostCode($this->faker->postcode())
            ->setResidenceCountryCode($this->faker->countryCode());

        $unit1 = (new ResidentialUnit())
            ->setType(ResidentialUnitType::APARTMENT)
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomNumber(2))
            ->setSingleBedCount($this->faker->randomNumber(1))
            ->setDoubleBedCount($this->faker->randomNumber(1))
            ->setTrundleBedCount($this->faker->randomNumber(1));

        $unit2 = (new ResidentialUnit())
            ->setType(ResidentialUnitType::APARTMENT)
            ->setBuilding($this->faker->randomLetter())
            ->setNumber($this->faker->randomNumber(2))
            ->setSingleBedCount($this->faker->randomNumber(1))
            ->setDoubleBedCount($this->faker->randomNumber(1))
            ->setTrundleBedCount($this->faker->randomNumber(1));

        $roomChange = (new RoomChange())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest)
            ->setOccupiedResidentialUnit($unit1)
            ->setAbandonedResidentialUnit($unit2);

        $reporting = Reporting::fake([
            'payload' => [
                'id' => $id = $this->faker->uuid(),
                'messageId' => $messageId = $this->faker->uuid(),
                'status' => 'pending',
                'reason' => $reason = $this->faker->word(),
                'type' => 'room-change',
                'context' => 'context',
                'response' => null,
            ],
        ]);

        $report = $reporting->roomChange($this->faker->uuid(), $roomChange);

        $this->assertSame($id, $report['payload']['id']);
        $this->assertSame($messageId, $report['payload']['messageId']);
        $this->assertSame('pending', $report['payload']['status']);
        $this->assertSame($reason, $report['payload']['reason']);
        $this->assertSame('room-change', $report['payload']['type']);
        $this->assertSame('context', $report['payload']['context']);
        $this->assertNull($report['payload']['response']);
    }

    public function testItThrowsExceptionIfTheRequestFails(): void
    {
        $reservation = (new Reservation())
            ->setReservationNumber($this->faker->numerify('#####'))
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setReservedAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setCancelled($this->faker->boolean())
            ->setNationality($this->faker->countryCode())
            ->setArrival($this->faker->dateTime()->format('Y-m-d'))
            ->setDeparture($this->faker->dateTime()->format('Y-m-d'))
            ->setSalesChannel(SalesChannel::DIRECTLY_ONLINE)
            ->setMarketSegment(MarketSegment::BUSINESS_GROUP)
            ->setGrossAmount($this->faker->randomFloat(2, 0, 1000))
            ->setGuestCount($this->faker->randomNumber(1))
            ->addBookedResidentialUnits(ResidentialUnitType::APARTMENT, $this->faker->randomNumber(1));

        $reporting = Reporting::fake([], 404);

        $this->expectException(ClientException::class);
        $reporting->reservation($this->faker->uuid(), $reservation);
    }
}
