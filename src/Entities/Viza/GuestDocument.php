<?php

namespace TmrwLife\NtakGuru\Entities\Viza;

use Illuminate\Contracts\Support\Arrayable;
use TmrwLife\NtakGuru\Enums\DocumentType;
use TmrwLife\NtakGuru\Enums\Gender;

class GuestDocument implements Arrayable
{
    protected ?string $birthFirstName = null;
    protected ?string $birthLastName = null;
    protected ?string $dateOfBirth = null;
    protected ?string $documentNumber = null;
    protected ?DocumentType $documentType = null;
    protected ?string $firstName = null;
    protected ?Gender $gender = null;
    protected ?string $lastName = null;
    protected ?string $motherFirstName = null;
    protected ?string $motherLastName = null;
    protected ?string $nationality = null;
    protected ?string $placeOfBirth = null;

    public function setBirthFirstName(string $birthFirstName): GuestDocument
    {
        $this->birthFirstName = $birthFirstName;

        return $this;
    }

    public function setBirthLastName(string $birthLastName): GuestDocument
    {
        $this->birthLastName = $birthLastName;

        return $this;
    }

    public function setDateOfBirth(string $dateOfBirth): GuestDocument
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function setDocumentNumber(string $documentNumber): GuestDocument
    {
        $this->documentNumber = $documentNumber;

        return $this;
    }

    public function setDocumentType(DocumentType $documentType): GuestDocument
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function setFirstName(string $firstName): GuestDocument
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setGender(Gender $gender): GuestDocument
    {
        $this->gender = $gender;

        return $this;
    }

    public function setLastName(string $lastName): GuestDocument
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setMotherFirstName(string $motherFirstName): GuestDocument
    {
        $this->motherFirstName = $motherFirstName;

        return $this;
    }

    public function setMotherLastName(string $motherLastName): GuestDocument
    {
        $this->motherLastName = $motherLastName;

        return $this;
    }

    public function setNationality(string $nationality): GuestDocument
    {
        $this->nationality = strtoupper($nationality);

        return $this;
    }

    public function setPlaceOfBirth(string $placeOfBirth): GuestDocument
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function toArray()
    {
        return [
            'birthFirstName' => $this->birthFirstName,
            'birthLastName' => $this->birthLastName,
            'dateOfBirth' => $this->dateOfBirth,
            'documentNumber' => $this->documentNumber,
            'documentType' => $this->documentType?->value,
            'firstName' => $this->firstName,
            'gender' => $this->gender?->value,
            'lastName' => $this->lastName,
            'motherFirstName' => $this->motherFirstName,
            'motherLastName' => $this->motherLastName,
            'nationality' => $this->nationality,
            'placeOfBirth' => $this->placeOfBirth,
        ];
    }
}
