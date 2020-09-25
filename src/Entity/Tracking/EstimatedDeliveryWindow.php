<?php

declare(strict_types=1);

namespace Rawilk\Ups\Entity\Tracking;

use Carbon\Carbon;
use Rawilk\Ups\Entity\Entity;

/**
 * @property \Carbon\Carbon $date
 * @property string $start_time Format: HH:MM:SS
 * @property string $end_time Format: HH:MM:SS
 */
class EstimatedDeliveryWindow extends Entity
{
    public function setDateAttribute($date): void
    {
        $this->attributes['date'] = Carbon::createFromFormat('mdY', $date, 'UTC')->startOfDay();
    }

    public function setStartTimeAttribute($startTime): void
    {
        $this->attributes['start_time'] = $this->parseTime($startTime);
    }

    public function setEndTimeAttribute($endTime): void
    {
        $this->attributes['end_time'] = $this->parseTime($endTime);
    }

    protected function parseTime($time): string
    {
        return Carbon::createFromFormat('His', $time, 'UTC')->format('H:i:s');
    }
}
