<?php

namespace Modules\Cars\Entities\Concerns;

use IntlDateFormatter;

trait FormatsHijriDates
{
    protected function toHijri(?\DateTimeInterface $date): ?string
    {
        if (!$date) {
            return null;
        }
        $formatter = new IntlDateFormatter(
            'ar_SA@calendar=islamic-umalqura',
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            config('app.timezone'),
            IntlDateFormatter::TRADITIONAL,
            'y-MM-dd'
        );
        return $formatter->format($date);
    }
}
