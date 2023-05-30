<?php

namespace TmrwLife\NtakGuru\Validation\Ntak;

use Illuminate\Validation\Factory;
use TmrwLife\NtakGuru\Entities\Ntak\CheckIn;
use TmrwLife\NtakGuru\Entities\Ntak\CheckOut;
use TmrwLife\NtakGuru\Entities\Ntak\DailyClose;
use TmrwLife\NtakGuru\Entities\Ntak\Reservation;
use TmrwLife\NtakGuru\Entities\Ntak\RoomChange;

class Validator
{
    use Rules;

    protected Factory $validator;

    protected array $errors = [];

    public function __construct(protected CheckIn|CheckOut|DailyClose|Reservation|RoomChange $report)
    {
        $this->validator = new Factory(trans());
    }

    public static function parse(CheckIn|CheckOut|DailyClose|Reservation|RoomChange $report): static
    {
        return new static($report);
    }

    public function validate(): bool
    {
        $rules = $this->getRules();

        $validator = $this->validator->make($this->report->toArray(), $rules);

        if ($validator->fails()) {
            $this->errors = $validator->errors()->toArray();

            return false;
        }

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function getRules(): array
    {
        return match ($this->report::class) {
            CheckIn::class => $this->ruleCheckIn(),
            CheckOut::class => $this->ruleCheckOut(),
            DailyClose::class => $this->ruleDailyClose(),
            Reservation::class => $this->ruleReservation(),
            RoomChange::class => $this->ruleRoomChange(),
        };
    }
}
