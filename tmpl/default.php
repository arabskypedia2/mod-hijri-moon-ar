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
 * @package     ArabSkyPedia.Module
 * @subpackage  mod_hijri_moon_ar
 */

\defined('_JEXEC') or die;

use ArabSkyPedia\Module\HijriMoonAr\Site\Helper\HijriMoonHelper;
use Joomla\CMS\Language\Text;

$y = (int) date('Y');
$m = (int) date('n');
$d = (int) date('j');

$phase = HijriMoonHelper::moonPhase($y, $m, $d);
$hijri = HijriMoonHelper::gregorianToHijriCivil($y, $m, $d);

$showHijri       = (bool) $params->get('show_hijri_date', 1);
$showIllumination = (bool) $params->get('show_illumination', 1);
?>
<div class="mod-hijri-moon-ar" dir="rtl" lang="ar">
    <?php if ($showHijri) : ?>
    <div class="mh-hijri-date">
        <?php echo $hijri['hd'] . ' ' . HijriMoonHelper::hijriMonthNameAr($hijri['hm']) . ' ' . $hijri['hy'] . ' هـ'; ?>
    </div>
    <?php endif; ?>
    <div class="mh-phase">
        <?php echo HijriMoonHelper::phaseNameAr($phase['phase_index']); ?>
        (<?php echo Text::sprintf('MOD_HIJRI_MOON_AR_MOON_AGE', $phase['age']); ?>)
    </div>
    <?php if ($showIllumination) : ?>
    <div class="mh-illumination">
        <?php echo Text::sprintf('MOD_HIJRI_MOON_AR_ILLUMINATION', $phase['illumination']); ?>
    </div>
    <?php endif; ?>
    <div class="mh-disclaimer">
        <?php echo Text::_('MOD_HIJRI_MOON_AR_DISCLAIMER'); ?>
    </div>
</div>
