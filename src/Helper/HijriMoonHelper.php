<?php

/**
 * Copyright (C) 2026 ArabSkyPedia.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see <https://www.gnu.org/licenses/>.
 *
 * Astronomical APPROXIMATION only. Moon phase is computed from a mean
 * synodic month and does NOT determine actual crescent visibility.
 * Hijri conversion is the civil/tabular arithmetic calendar; it may
 * differ by a day from official calendars that apply their own rules
 * (e.g. Umm al-Qura) and from local sighting announcements.
 *
 * @package     ArabSkyPedia.Module
 * @subpackage  mod_hijri_moon_ar
 */

namespace ArabSkyPedia\Module\HijriMoonAr\Site\Helper;

\defined('_JEXEC') or die;

class HijriMoonHelper
{
    /** New moon reference epoch: 2000-01-06 18:14 UTC (Julian date). */
    private const NEW_MOON_EPOCH_JD = 2451550.26;

    /** Mean synodic month in days. */
    private const SYNODIC_MONTH = 29.530588853;

    /**
     * Gregorian date -> Julian day number (integer, noon-based civil algorithm).
     */
    public static function gregorianToJd(int $year, int $month, int $day): float
    {
        if ($month <= 2) {
            $year -= 1;
            $month += 12;
        }

        $a = intdiv($year, 100);
        $b = 2 - $a + intdiv($a, 4);

        return (float) (intdiv(36525 * ($year + 4716), 100)
            + intdiv(306001 * ($month + 1), 10000)
            + $day + $b - 1524);
    }

    /**
     * Moon age in days (0 .. 29.53) and illuminated fraction (0..1).
     * Mean-motion approximation; actual crescent visibility is NOT implied.
     *
     * @return array{age: float, illumination: float, phase_index: int}
     */
    public static function moonPhase(int $year, int $month, int $day): array
    {
        $jd   = self::gregorianToJd($year, $month, $day);
        $age  = fmod($jd - self::NEW_MOON_EPOCH_JD, self::SYNODIC_MONTH);
        if ($age < 0) {
            $age += self::SYNODIC_MONTH;
        }

        $phaseFraction = $age / self::SYNODIC_MONTH;
        $illumination  = (1 - cos(2 * M_PI * $phaseFraction)) / 2;
        $phaseIndex    = (int) floor(($phaseFraction * 8) + 0.5) % 8;

        return [
            'age'          => round($age, 1),
            'illumination' => round($illumination * 100),
            'phase_index'  => $phaseIndex,
        ];
    }

    /**
     * Civil (tabular) Hijri date from a Gregorian date.
     * Standard Kuwaiti civil algorithm. NOT observation-based.
     *
     * @return array{hy: int, hm: int, hd: int}
     */
    public static function gregorianToHijriCivil(int $year, int $month, int $day): array
    {
        $jd = (int) self::gregorianToJd($year, $month, $day);

        // Julian day of 1 Muharram 1 AH (civil epoch, Friday epoch variant)
        $l   = $jd - 1948440 + 10632;
        $n   = intdiv($l - 1, 10631);
        $l   = $l - 10631 * $n + 354;
        $j   = intdiv(10985 - $l, 5316) * intdiv(50 * $l, 17719)
             + intdiv($l, 5670) * intdiv(43 * $l, 15238);
        $l   = $l - intdiv(30 - $j, 15) * intdiv(17719 * $j, 50)
             - intdiv($j, 16) * intdiv(15238 * $j, 43) + 29;
        $hm  = intdiv(24 * $l, 709);
        $hd  = $l - intdiv(709 * $hm, 24);
        $hy  = 30 * $n + $j - 30;

        return ['hy' => $hy, 'hm' => $hm, 'hd' => $hd];
    }

    /** Arabic names of the eight principal phases, indexed by phase_index. */
    public static function phaseNameAr(int $phaseIndex): string
    {
        $names = [
            0 => 'محاق',
            1 => 'هلال أول',
            2 => 'تربيع أول',
            3 => 'أحدب متزايد',
            4 => 'بدر',
            5 => 'أحدب متناقص',
            6 => 'تربيع أخير',
            7 => 'هلال أخير',
        ];

        return $names[$phaseIndex % 8];
    }

    /** Arabic names of Hijri months (1-based index). */
    public static function hijriMonthNameAr(int $month): string
    {
        $names = [
            1 => 'محرم',
            2 => 'صفر',
            3 => 'ربيع الأول',
            4 => 'ربيع الآخر',
            5 => 'جمادى الأولى',
            6 => 'جمادى الآخرة',
            7 => 'رجب',
            8 => 'شعبان',
            9 => 'رمضان',
            10 => 'شوال',
            11 => 'ذو القعدة',
            12 => 'ذو الحجة',
        ];

        return $names[((($month - 1) % 12) + 1)];
    }
}
