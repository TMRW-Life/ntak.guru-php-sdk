<?php

namespace TmrwLife\NtakGuru\Tests\Services\Reporting;

use GuzzleHttp\Exception\ClientException;
use TmrwLife\NtakGuru\Entities\Viza\CheckIn;
use TmrwLife\NtakGuru\Entities\Viza\CheckOut;
use TmrwLife\NtakGuru\Entities\Viza\Guest;
use TmrwLife\NtakGuru\Entities\Viza\GuestDocument;
use TmrwLife\NtakGuru\Enums\DocumentType;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Services\Reporting\Viza;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class VizaTest extends TestCase
{
    use WithFaker;

    public function testItSendsCheckInRequest(): void
    {
        $guestDocumentManual = (new GuestDocument())
            ->setBirthFirstName($this->faker->firstName())
            ->setBirthLastName($this->faker->lastName())
            ->setDateOfBirth($this->faker->date())
            ->setDocumentNumber($this->faker->uuid())
            ->setDocumentType(DocumentType::from($this->faker->randomElement(DocumentType::values())))
            ->setFirstName($this->faker->firstName())
            ->setGender(Gender::from($this->faker->randomElement(Gender::values())))
            ->setLastName($this->faker->lastName())
            ->setMotherFirstName($this->faker->firstName())
            ->setMotherLastName($this->faker->lastName())
            ->setNationality($this->faker->countryCode())
            ->setPlaceOfBirth($this->faker->city());

        $guestDocumentScanned = (new GuestDocument())
            ->setBirthFirstName($this->faker->firstName())
            ->setBirthLastName($this->faker->lastName())
            ->setDateOfBirth($this->faker->date())
            ->setDocumentNumber($this->faker->uuid())
            ->setDocumentType(DocumentType::from($this->faker->randomElement(DocumentType::values())))
            ->setFirstName($this->faker->firstName())
            ->setGender(Gender::from($this->faker->randomElement(Gender::values())))
            ->setLastName($this->faker->lastName())
            ->setMotherFirstName($this->faker->firstName())
            ->setMotherLastName($this->faker->lastName())
            ->setNationality($this->faker->countryCode())
            ->setPlaceOfBirth($this->faker->city());

        $guest = (new Guest())
            ->setArrival($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setDeparture($this->faker->dateTime()->format('Y-m-d'))
            ->setGuestNumber($this->faker->uuid())
            ->setManual($guestDocumentManual)
            ->setScanned($guestDocumentScanned)
            ->setVisaDateOfEntry($this->faker->dateTime()->format('Y-m-d'))
            ->setVisaNumber($this->faker->uuid())
            ->setVisaPlaceOfEntry($this->faker->city());

        $checkIn = (new CheckIn())
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest);

        $gateway = Viza::fake([
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

        $report = $gateway->checkIn($this->faker->uuid(), $checkIn);

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
        $checkOut = (new CheckOut())
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest(
                id: $this->faker->uuid(),
                departure: $this->faker->dateTime()->format('Y-m-d H:i:s'),
            );

        $gateway = Viza::fake([
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

        $report = $gateway->checkOut($this->faker->uuid(), $checkOut);

        $this->assertSame($id, $report['payload']['id']);
        $this->assertSame($messageId, $report['payload']['messageId']);
        $this->assertSame('pending', $report['payload']['status']);
        $this->assertSame($reason, $report['payload']['reason']);
        $this->assertSame('check-out', $report['payload']['type']);
        $this->assertSame('context', $report['payload']['context']);
        $this->assertNull($report['payload']['response']);
    }

    public function testItThrowsExceptionIfTheRequestFails(): void
    {
        $guestDocumentManual = (new GuestDocument())
            ->setBirthFirstName($this->faker->firstName())
            ->setBirthLastName($this->faker->lastName())
            ->setDateOfBirth($this->faker->date())
            ->setDocumentNumber($this->faker->uuid())
            ->setDocumentType(DocumentType::from($this->faker->randomElement(DocumentType::values())))
            ->setFirstName($this->faker->firstName())
            ->setGender(Gender::from($this->faker->randomElement(Gender::values())))
            ->setLastName($this->faker->lastName())
            ->setMotherFirstName($this->faker->firstName())
            ->setMotherLastName($this->faker->lastName())
            ->setNationality($this->faker->countryCode())
            ->setPlaceOfBirth($this->faker->city());

        $guestDocumentScanned = (new GuestDocument())
            ->setBirthFirstName($this->faker->firstName())
            ->setBirthLastName($this->faker->lastName())
            ->setDateOfBirth($this->faker->date())
            ->setDocumentNumber($this->faker->uuid())
            ->setDocumentType(DocumentType::from($this->faker->randomElement(DocumentType::values())))
            ->setFirstName($this->faker->firstName())
            ->setGender(Gender::from($this->faker->randomElement(Gender::values())))
            ->setLastName($this->faker->lastName())
            ->setMotherFirstName($this->faker->firstName())
            ->setMotherLastName($this->faker->lastName())
            ->setNationality($this->faker->countryCode())
            ->setPlaceOfBirth($this->faker->city());

        $guest = (new Guest())
            ->setArrival($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setDeparture($this->faker->dateTime()->format('Y-m-d'))
            ->setGuestNumber($this->faker->uuid())
            ->setManual($guestDocumentManual)
            ->setScanned($guestDocumentScanned)
            ->setVisaDateOfEntry($this->faker->dateTime()->format('Y-m-d'))
            ->setVisaNumber($this->faker->uuid())
            ->setVisaPlaceOfEntry($this->faker->city());

        $checkIn = (new CheckIn())
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest);

        $gateway = Viza::fake([], 404);

        $this->expectException(ClientException::class);
        $gateway->checkIn($this->faker->uuid(), $checkIn);
    }
}
