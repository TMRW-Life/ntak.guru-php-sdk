<?php

namespace TmrwLife\NtakGuru\Tests\Validation\Viza;

use TmrwLife\NtakGuru\Entities\Viza\CheckIn;
use TmrwLife\NtakGuru\Entities\Viza\Guest;
use TmrwLife\NtakGuru\Entities\Viza\GuestDocument;
use TmrwLife\NtakGuru\Enums\DocumentType;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;
use TmrwLife\NtakGuru\Validation\Viza\Validator;

class CheckInValidationTest extends TestCase
{
    use WithFaker;

    public function testItCheckInValidationFail(): void
    {
        $checkIn = (new CheckIn());

        $validator = Validator::parse($checkIn);

        $this->assertFalse($validator->validate());

        $this->assertArrayHasKey('occurredAt', $validator->getErrors());
        $this->assertArrayHasKey('guests', $validator->getErrors());
    }

    public function testItCheckInValidationSuccess(): void
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
            ->setId($this->faker->uuid())
            ->setManual($guestDocumentManual)
            ->setScanned($guestDocumentScanned)
            ->setVisaDateOfEntry($this->faker->dateTime()->format('Y-m-d'))
            ->setVisaNumber($this->faker->uuid())
            ->setVisaPlaceOfEntry($this->faker->city());

        $checkIn = (new CheckIn())
            ->setOccurredAt($this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest);

        $validator = Validator::parse($checkIn);

        $this->assertTrue($validator->validate());
    }
}
