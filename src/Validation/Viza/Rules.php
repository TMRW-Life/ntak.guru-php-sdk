<?php

namespace TmrwLife\NtakGuru\Validation\Viza;

use Illuminate\Validation\Rule;
use TmrwLife\NtakGuru\Enums\DocumentType;
use TmrwLife\NtakGuru\Enums\Gender;

trait Rules
{
    protected function ruleCheckIn(): array
    {
        return [
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'guests' => ['required', 'array', 'min:1'],
            'guests.*.id' => ['required', 'uuid'],
            'guests.*.arrival' => ['required', 'date_format:Y-m-d H:i:s'],
            'guests.*.departure' => ['required', 'date_format:Y-m-d'],

            'guests.*.manual' => ['required', 'array'],
            'guests.*.manual.firstName' => ['required', 'string'],
            'guests.*.manual.lastName' => ['required', 'string'],
            'guests.*.manual.birthFirstName' => ['nullable', 'string'],
            'guests.*.manual.birthLastName' => ['nullable', 'string'],
            'guests.*.manual.dateOfBirth' => ['nullable', 'date_format:Y-m-d'],
            'guests.*.manual.placeOfBirth' => ['nullable', 'string'],
            'guests.*.manual.motherFirstName' => ['nullable', 'string'],
            'guests.*.manual.motherLastName' => ['nullable', 'string'],
            'guests.*.manual.nationality' => ['nullable', 'string', 'size:2'],
            'guests.*.manual.gender' => ['nullable', Rule::enum(Gender::class)],
            'guests.*.manual.documentType' => ['required', Rule::enum(DocumentType::class)],
            'guests.*.manual.documentNumber' => ['required', 'string'],

            'guests.*.scanned' => ['required', 'array'],
            'guests.*.scanned.firstName' => ['required', 'string'],
            'guests.*.scanned.lastName' => ['required', 'string'],
            'guests.*.scanned.birthFirstName' => ['nullable', 'string'],
            'guests.*.scanned.birthLastName' => ['nullable', 'string'],
            'guests.*.scanned.dateOfBirth' => ['nullable', 'date_format:Y-m-d'],
            'guests.*.scanned.placeOfBirth' => ['nullable', 'string'],
            'guests.*.scanned.motherFirstName' => ['nullable', 'string'],
            'guests.*.scanned.motherLastName' => ['nullable', 'string'],
            'guests.*.scanned.nationality' => ['nullable', 'string', 'size:2'],
            'guests.*.scanned.gender' => ['nullable', Rule::enum(Gender::class)],
            'guests.*.scanned.documentType' => ['required', Rule::enum(DocumentType::class)],
            'guests.*.scanned.documentNumber' => ['required', 'string'],

            'guests.*.visaNumber' => ['nullable', 'string'],
            'guests.*.visaDateOfEntry' => ['nullable', 'date_format:Y-m-d'],
            'guests.*.visaPlaceOfEntry' => ['nullable', 'string'],
        ];
    }

    protected function ruleCheckOut(): array
    {
        return [
            'occurredAt' => ['required', 'date_format:Y-m-d H:i:s'],
            'guests' => ['required', 'array', 'min:1'],
            'guests.*.id' => ['required', 'uuid'],
            'guests.*.departure' => ['required', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
