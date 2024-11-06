<?php

namespace TmrwLife\NtakGuru\Tests\Entities\Viza;

use TmrwLife\NtakGuru\Entities\Viza\CheckIn;
use TmrwLife\NtakGuru\Entities\Viza\Guest;
use TmrwLife\NtakGuru\Entities\Viza\GuestDocument;
use TmrwLife\NtakGuru\Enums\DocumentType;
use TmrwLife\NtakGuru\Enums\Gender;
use TmrwLife\NtakGuru\Tests\TestCase;
use TmrwLife\NtakGuru\Tests\Traits\WithFaker;

class CheckInTest extends TestCase
{
    use WithFaker;

    public function testItBuildsTheCheckInArray(): void
    {
        $guestDocumentManual = (new GuestDocument())
            ->setBirthFirstName($guestDocumentManualBirthFirstName = $this->faker->firstName())
            ->setBirthLastName($guestDocumentManualBirthLastName = $this->faker->lastName())
            ->setDateOfBirth($guestDocumentManualDateOfBirth = $this->faker->date())
            ->setDocumentNumber($guestDocumentManualDocumentNumber = $this->faker->uuid())
            ->setDocumentType($guestDocumentManualDocumentType = DocumentType::from($this->faker->randomElement(DocumentType::values())))
            ->setFirstName($guestDocumentManualFirstName = $this->faker->firstName())
            ->setGender($guestDocumentManualGender = Gender::from($this->faker->randomElement(Gender::values())))
            ->setLastName($guestDocumentManualLastName = $this->faker->lastName())
            ->setMotherFirstName($guestDocumentManualMotherFirstName = $this->faker->firstName())
            ->setMotherLastName($guestDocumentManualMotherLastName = $this->faker->lastName())
            ->setNationality($guestDocumentManualNationality = $this->faker->countryCode())
            ->setPlaceOfBirth($guestDocumentManualPlaceOfBirth = $this->faker->city());

        $guestDocumentScanned = (new GuestDocument())
            ->setBirthFirstName($guestDocumentScannedBirthFirstName = $this->faker->firstName())
            ->setBirthLastName($guestDocumentScannedBirthLastName = $this->faker->lastName())
            ->setDateOfBirth($guestDocumentScannedDateOfBirth = $this->faker->date())
            ->setDocumentNumber($guestDocumentScannedDocumentNumber = $this->faker->uuid())
            ->setDocumentType($guestDocumentScannedDocumentType = DocumentType::from($this->faker->randomElement(DocumentType::values())))
            ->setFirstName($guestDocumentScannedFirstName = $this->faker->firstName())
            ->setGender($guestDocumentScannedGender = Gender::from($this->faker->randomElement(Gender::values())))
            ->setLastName($guestDocumentScannedLastName = $this->faker->lastName())
            ->setMotherFirstName($guestDocumentScannedMotherFirstName = $this->faker->firstName())
            ->setMotherLastName($guestDocumentScannedMotherLastName = $this->faker->lastName())
            ->setNationality($guestDocumentScannedNationality = $this->faker->countryCode())
            ->setPlaceOfBirth($guestDocumentScannedPlaceOfBirth = $this->faker->city());

        $guest = (new Guest())
            ->setArrival($guestArrival = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->setDeparture($guestDeparture = $this->faker->dateTime()->format('Y-m-d'))
            ->setId($guestId = $this->faker->uuid())
            ->setManual($guestDocumentManual)
            ->setScanned($guestDocumentScanned)
            ->setVisaDateOfEntry($guestVisaDateOfEntry = $this->faker->dateTime()->format('Y-m-d'))
            ->setVisaNumber($guestVisaNumber = $this->faker->uuid())
            ->setVisaPlaceOfEntry($guestVisaPlaceOfEntry = $this->faker->city());


        $checkIn = (new CheckIn())
            ->setOccurredAt($occurredAt = $this->faker->dateTime()->format('Y-m-d H:i:s'))
            ->addGuest($guest);

        $this->assertSame([
            'guests' => [
                [
                    'arrival' => $guestArrival,
                    'departure' => $guestDeparture,
                    'id' => $guestId,
                    'manual' => [
                        'birthFirstName' => $guestDocumentManualBirthFirstName,
                        'birthLastName' => $guestDocumentManualBirthLastName,
                        'dateOfBirth' => $guestDocumentManualDateOfBirth,
                        'documentNumber' => $guestDocumentManualDocumentNumber,
                        'documentType' => $guestDocumentManualDocumentType->value,
                        'firstName' => $guestDocumentManualFirstName,
                        'gender' => $guestDocumentManualGender->value,
                        'lastName' => $guestDocumentManualLastName,
                        'motherFirstName' => $guestDocumentManualMotherFirstName,
                        'motherLastName' => $guestDocumentManualMotherLastName,
                        'nationality' => $guestDocumentManualNationality,
                        'placeOfBirth' => $guestDocumentManualPlaceOfBirth,
                    ],
                    'scanned' => [
                        'birthFirstName' => $guestDocumentScannedBirthFirstName,
                        'birthLastName' => $guestDocumentScannedBirthLastName,
                        'dateOfBirth' => $guestDocumentScannedDateOfBirth,
                        'documentNumber' => $guestDocumentScannedDocumentNumber,
                        'documentType' => $guestDocumentScannedDocumentType->value,
                        'firstName' => $guestDocumentScannedFirstName,
                        'gender' => $guestDocumentScannedGender->value,
                        'lastName' => $guestDocumentScannedLastName,
                        'motherFirstName' => $guestDocumentScannedMotherFirstName,
                        'motherLastName' => $guestDocumentScannedMotherLastName,
                        'nationality' => $guestDocumentScannedNationality,
                        'placeOfBirth' => $guestDocumentScannedPlaceOfBirth,
                    ],
                    'visaDateOfEntry' => $guestVisaDateOfEntry,
                    'visaNumber' => $guestVisaNumber,
                    'visaPlaceOfEntry' => $guestVisaPlaceOfEntry,
                ],
            ],
            'occurredAt' => $occurredAt,
        ], $checkIn->toArray());
    }
}
