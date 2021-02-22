<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Activity;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Rawilk\Ups\Entity\Entity;
use Rawilk\Ups\Entity\Tracking\Status;

/**
 * @property string $date Format: YYYYMMDD
 * @property string $time Format: HHMMSS or HHMM
 * @property null|string $gmt_date Format: YYYY-MM-DD
 * @property null|string $gmt_time Format: hh:mm:ss or hh:mm
 * @property null|string $gmt_offset Format: (+/-) hh:mm
 * @property \Carbon\Carbon $date_time Parsed date and time object. Tries to use GMT date/time first, but falls back on date/time.
 * @property null|string $signed_for_by_name
 *      If this activity is a delivery activity and there is a signature, it will be returned from the <ActivityLocation> Container.
 * @property null|\Rawilk\Ups\Entity\Activity\ActivityLocation $activity_location
 * @property null|\Rawilk\Ups\Entity\Tracking\Status $status Package activity status container.
 */
class Activity extends Entity
{
    public function activityLocation(): string
    {
        return ActivityLocation::class;
    }

    public function status(): string
    {
        return Status::class;
    }

    /*
     * Indicates if this activity is a pickup activity.
     */
    public function isPickup(): bool
    {
        if (! $this->status) {
            return false;
        }

        return $this->status->isPickup();
    }

    /*
     * Indicates if this activity is a delivered activity.
     */
    public function isDelivered(): bool
    {
        if (! $this->status) {
            return false;
        }

        return $this->status->isDelivered();
    }

    public function getSignedForByNameAttribute(): null|string
    {
        return $this->activity_location->signed_for_by_name ?? null;
    }

    public function getDateTimeAttribute(): Carbon
    {
        if ($this->gmt_date && $this->gmt_time) {
            return $this->parseGMTDateTime();
        }

        return Carbon::createFromFormat("Ymd {$this->regularTimeFormat()}", "{$this->date} {$this->time}");
    }

    protected function parseGMTDateTime(): Carbon
    {
        $offset = $this->gmt_offset ?? '+00:00';

        return Carbon::createFromFormat("Y-m-d {$this->gmtTimeFormat()}", "{$this->gmt_date} {$this->gmt_time}", $offset);
    }

    protected function regularTimeFormat(): string
    {
        return Str::length($this->time) === 6
            ? 'His'
            : 'Hi';
    }

    protected function gmtTimeFormat(): string
    {
        $separator = Str::contains($this->gmt_time, ':') ? ':' : '.';

        $parts = explode($separator, $this->gmt_time);

        $format = "H{$separator}i";

        if (count($parts) === 3) {
            $format .= "{$separator}s";
        }

        return $format;
    }
}
